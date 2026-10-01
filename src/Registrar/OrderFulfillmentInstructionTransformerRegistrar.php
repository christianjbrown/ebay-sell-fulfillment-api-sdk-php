<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppointmentDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PickupStepTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingStepTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order fulfillment start instruction transformers (pickup, shipping and appointment steps). Must run after {@see OrderBuyerTransformerRegistrar}.
 */
final class OrderFulfillmentInstructionTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_APPOINTMENT_DETAILS_TRANSFORMER, AppointmentDetailsTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PICKUP_STEP_TRANSFORMER, PickupStepTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_SHIPPING_STEP_TRANSFORMER, ShippingStepTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EXTENDED_CONTACT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTION_TRANSFORMER, FulfillmentStartInstructionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ADDRESS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PICKUP_STEP_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SHIPPING_STEP_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_APPOINTMENT_DETAILS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTIONS_TRANSFORMER, FulfillmentStartInstructionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );
    }
}
