<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionsToReleaseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionToReleaseTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order refund, payment hold, payment and payment summary transformers. Must run after {@see OrderPricingTransformerRegistrar}.
 */
final class OrderPaymentTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_ORDER_REFUND_TRANSFORMER, OrderRefundTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_REFUNDS_TRANSFORMER, OrderRefundsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_REFUND_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_SELLER_ACTION_TO_RELEASE_TRANSFORMER, SellerActionToReleaseTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_SELLER_ACTIONS_TO_RELEASE_TRANSFORMER, SellerActionsToReleaseTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SELLER_ACTION_TO_RELEASE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_HOLD_TRANSFORMER, PaymentHoldTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SELLER_ACTIONS_TO_RELEASE_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_HOLDS_TRANSFORMER, PaymentHoldsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_HOLD_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_TRANSFORMER, PaymentTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_HOLDS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENTS_TRANSFORMER, PaymentsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_SUMMARY_TRANSFORMER, PaymentSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_REFUNDS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENTS_TRANSFORMER),
                ]
            );
    }
}
