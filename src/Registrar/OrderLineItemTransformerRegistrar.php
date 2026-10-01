<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\GiftDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemFulfillmentInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemPropertiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertyTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order line item transformers and the property, location, refund and linked-order pieces they compose. Must run after {@see OrderPricingTransformerRegistrar}.
 */
final class OrderLineItemTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_PROPERTY_TRANSFORMER, PropertyTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PROPERTIES_TRANSFORMER, PropertiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PROPERTY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_GIFT_DETAILS_TRANSFORMER, GiftDetailsTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_ITEM_LOCATION_TRANSFORMER, ItemLocationTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_FULFILLMENT_INSTRUCTIONS_TRANSFORMER, LineItemFulfillmentInstructionsTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_PROPERTIES_TRANSFORMER, LineItemPropertiesTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUND_TRANSFORMER, LineItemRefundTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUNDS_TRANSFORMER, LineItemRefundsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUND_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIR_TRANSFORMER, NameValuePairTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER, NameValuePairsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIR_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEM_TRANSFORMER, LinkedOrderLineItemTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TRACKING_INFOS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEMS_TRANSFORMER, LinkedOrderLineItemsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_TRANSFORMER, LineItemTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTIONS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_DELIVERY_COST_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAXES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_COLLECTED_CHARGES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_GIFT_DETAILS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_FULFILLMENT_INSTRUCTIONS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_PROPERTIES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUNDS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEMS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAXES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PROPERTIES_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEMS_TRANSFORMER, LineItemsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );
    }
}
