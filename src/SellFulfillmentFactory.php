<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\ApiClient\ApiClientFactory;
use ChristianBrown\ApiClient\ClientOptions;
use ChristianBrown\EBay\SellFulfillment\Auth\ApplicationCredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderApiRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderBuyerTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderCancelTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderFulfillmentInstructionTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderLineItemTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderPaymentTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderPricingTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderProgramTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderResultTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderSerializerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\PaymentDisputeEvidenceServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\PaymentDisputeServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\ShippingFulfillmentServiceRegistrar;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\Lock\LockInterface;
use ChristianBrown\OAuth2Client\RefreshTokenManagerFactory;
use Symfony\Component\Clock\NativeClock;

/**
 * The composition root: builds the container from one registrar per cohesive
 * group of services, then hands it to the {@see SellFulfillment} facade.
 * `CoreServiceRegistrar` must come first, and the order registrars run in
 * dependency order.
 */
final class SellFulfillmentFactory implements SellFulfillmentFactoryInterface
{
    public function create(ApplicationCredentialsInterface $credentials, TtlAwareKeyValueStoreInterface $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, LockInterface $lock): SellFulfillmentInterface
    {
        return $this->createForHost($credentials, $accessTokenStore, $refreshTokenStore, $lock, new ApiHost());
    }

    public function createForHost(ApplicationCredentialsInterface $credentials, TtlAwareKeyValueStoreInterface $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, LockInterface $lock, ApiHostInterface $apiHost): SellFulfillmentInterface
    {
        $containerFactory = new ContainerFactory();
        $apiClient = (new ApiClientFactory(new ClientOptions()))->create();
        $refreshTokenManagerFactory = new RefreshTokenManagerFactory(new NativeClock());

        return new SellFulfillment(
            $containerFactory->build(
                [
                    new CoreServiceRegistrar($credentials, $apiClient, $refreshTokenManagerFactory, $accessTokenStore, $refreshTokenStore, $lock, $apiHost),
                    new OrderPricingTransformerRegistrar(),
                    new OrderBuyerTransformerRegistrar(),
                    new OrderCancelTransformerRegistrar(),
                    new OrderFulfillmentInstructionTransformerRegistrar(),
                    new OrderLineItemTransformerRegistrar(),
                    new OrderPaymentTransformerRegistrar(),
                    new OrderProgramTransformerRegistrar(),
                    new OrderResultTransformerRegistrar(),
                    new OrderSerializerRegistrar(),
                    new OrderApiRegistrar($apiHost),
                    new ShippingFulfillmentServiceRegistrar($apiHost),
                    new PaymentDisputeServiceRegistrar($apiHost),
                    new PaymentDisputeEvidenceServiceRegistrar($apiHost),
                ]
            )
        );
    }
}
