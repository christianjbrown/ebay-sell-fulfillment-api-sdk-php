<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderSearchPagedCollectionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrdersTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\RefundTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order the order, orders list, paged search and refund-result transformers that the order API returns. Must run after every other order transformer registrar.
 */
final class OrderResultTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_ORDER_TRANSFORMER, OrderTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_BUYER_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CANCEL_STATUS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTIONS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEMS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_SUMMARY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PRICING_SUMMARY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PROGRAM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDERS_TRANSFORMER, OrdersTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_SEARCH_PAGED_COLLECTION_TRANSFORMER, OrderSearchPagedCollectionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDERS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_REFUND_TRANSFORMER, RefundTransformer::class);
    }
}
