<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformer;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformer;
use ChristianBrown\EBay\SellFulfillment\Auth\ApplicationCredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\Credentials;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\Http\MultipartFormDataBuilder;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuard;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\StringsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfosTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfoTransformer;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\Lock\LockInterface;
use ChristianBrown\OAuth2Client\RefreshTokenManager;
use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers the API client, the OAuth token-refresh machinery, and every
 * transformer shared across more than one resource group (errors, tracking
 * info). Must run before every other registrar.
 */
final class CoreServiceRegistrar implements ServiceRegistrarInterface
{
    private TtlAwareKeyValueStoreInterface $accessTokenStore;
    private ApiHostInterface $apiHost;
    private ApplicationCredentialsInterface $applicationCredentials;
    private ?LockInterface $lock;
    private KeyValueStoreInterface $refreshTokenStore;

    public function __construct(ApplicationCredentialsInterface $applicationCredentials, TtlAwareKeyValueStoreInterface $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, ?LockInterface $lock, ApiHostInterface $apiHost)
    {
        $this->applicationCredentials = $applicationCredentials;
        $this->accessTokenStore = $accessTokenStore;
        $this->refreshTokenStore = $refreshTokenStore;
        $this->lock = $lock;
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        self::registerApiClient($container);
        $this->registerAuth($container);
        self::registerSharedTransformers($container);
    }

    private static function registerApiClient(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_API_CLIENT, ApiClient::class);
        $container->register(SellFulfillmentInterface::SERVICE_API_REQUEST_SENDER, ApiRequestSenderInterface::class)
            ->setFactory([new Reference(SellFulfillmentInterface::SERVICE_API_CLIENT), 'getApiRequestSender']);
        $container->register(SellFulfillmentInterface::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(SellFulfillmentInterface::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $container->register(SellFulfillmentInterface::SERVICE_ARRAY_TO_JSON_TRANSFORMER, ArrayToJsonTransformer::class);
        $container->register(SellFulfillmentInterface::SERVICE_JSON_TO_ARRAY_TRANSFORMER, JsonToArrayTransformer::class);
        $container->register(SellFulfillmentInterface::SERVICE_MULTIPART_FORM_DATA_BUILDER, MultipartFormDataBuilder::class);
    }

    private function registerAuth(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_ACCESS_TOKEN_TRANSFORMER, AccessTokenTransformer::class);

        // eBay's token endpoint authenticates with HTTP Basic (App ID and Cert ID)
        // and rotates the refresh token on every refresh, so the refresh-token
        // store must persist and the optional lock serialises concurrent refreshes.
        $container->register(SellFulfillmentInterface::SERVICE_REFRESH_TOKEN_MANAGER, RefreshTokenManager::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->accessTokenStore,
                    $this->refreshTokenStore,
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ACCESS_TOKEN_TRANSFORMER),
                    $this->apiHost->getOAuthTokenUrl(),
                    $this->applicationCredentials->getClientSecret(),
                    $this->lock,
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_CREDENTIALS, Credentials::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_REFRESH_TOKEN_MANAGER),
                    $this->applicationCredentials->getClientId(),
                    $this->applicationCredentials->getMarketplaceId(),
                ]
            );
    }

    private static function registerSharedTransformers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD, ArrayShapeGuard::class);

        $container->register(SellFulfillmentInterface::SERVICE_ERROR_PARAMETER_TRANSFORMER, ErrorParameterTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_ERROR_PARAMETERS_TRANSFORMER, ErrorParametersTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ERROR_PARAMETER_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_STRINGS_TRANSFORMER, StringsTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_ERROR_TRANSFORMER, ErrorTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ERROR_PARAMETERS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ERRORS_TRANSFORMER, ErrorsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ERROR_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_TRACKING_INFO_TRANSFORMER, TrackingInfoTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_TRACKING_INFOS_TRANSFORMER, TrackingInfosTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TRACKING_INFO_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );
    }
}
