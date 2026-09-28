<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApi;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferencesSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ShippingFulfillmentDetailsSerializer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferencesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentPagedCollectionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers everything `getShippingFulfillmentApi()` needs. Must run after
 * {@see CoreServiceRegistrar}.
 */
final class ShippingFulfillmentServiceRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        self::registerSerializers($container);
        self::registerTransformers($container);
        $this->registerApiClient($container);
    }

    private function registerApiClient(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_API, ShippingFulfillmentApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_API_REQUEST_SENDER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_TO_JSON_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_PAGED_COLLECTION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_DETAILS_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CREDENTIALS),
                    $this->apiHost,
                ]
            );
    }

    private static function registerSerializers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCE_SERIALIZER, LineItemReferenceSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCES_SERIALIZER, LineItemReferencesSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCE_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_DETAILS_SERIALIZER, ShippingFulfillmentDetailsSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCES_SERIALIZER),
                ]
            );
    }

    private static function registerTransformers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCE_TRANSFORMER, LineItemReferenceTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCES_TRANSFORMER, LineItemReferencesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_TRANSFORMER, ShippingFulfillmentTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFERENCES_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENTS_TRANSFORMER, ShippingFulfillmentsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_PAGED_COLLECTION_TRANSFORMER, ShippingFulfillmentPagedCollectionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENTS_TRANSFORMER),
                ]
            );
    }
}
