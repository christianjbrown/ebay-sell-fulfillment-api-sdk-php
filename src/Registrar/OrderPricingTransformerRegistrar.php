<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargeTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DeliveryCostTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectedChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayTaxReferenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PricingSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order amount, charge, promotion, tax, delivery cost and pricing summary transformers. Must run after {@see CoreServiceRegistrar}.
 */
final class OrderPricingTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER, AmountTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_CHARGE_TRANSFORMER, ChargeTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_CHARGES_TRANSFORMER, ChargesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CHARGE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTION_TRANSFORMER, AppliedPromotionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTIONS_TRANSFORMER, AppliedPromotionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_TAX_TRANSFORMER, TaxTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_TAXES_TRANSFORMER, TaxesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAX_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_DELIVERY_COST_TRANSFORMER, DeliveryCostTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_TAX_REFERENCE_TRANSFORMER, EbayTaxReferenceTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAX_TRANSFORMER, EbayCollectAndRemitTaxTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_TAX_REFERENCE_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAXES_TRANSFORMER, EbayCollectAndRemitTaxesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAX_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_COLLECTED_CHARGES_TRANSFORMER, EbayCollectedChargesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CHARGES_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PRICING_SUMMARY_TRANSFORMER, PricingSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );
    }
}
