<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\IssueRefundRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LegacyReferenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemsSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\SimpleAmountSerializer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the serializers `OrderApi` uses to build the issue-refund request body.
 */
final class OrderSerializerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_LEGACY_REFERENCE_SERIALIZER, LegacyReferenceSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_SERIALIZER, SimpleAmountSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_REFUND_ITEM_SERIALIZER, RefundItemSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LEGACY_REFERENCE_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_REFUND_ITEMS_SERIALIZER, RefundItemsSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_REFUND_ITEM_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ISSUE_REFUND_REQUEST_SERIALIZER, IssueRefundRequestSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_REFUND_ITEMS_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_SERIALIZER),
                ]
            );
    }
}
