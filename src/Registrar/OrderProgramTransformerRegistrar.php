<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayFulfillmentProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayInternationalShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayVaultProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PostSaleAuthenticationProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ProgramTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order eBay program transformers. Must run after {@see CoreServiceRegistrar}.
 */
final class OrderProgramTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_EBAY_FULFILLMENT_PROGRAM_TRANSFORMER, EbayFulfillmentProgramTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_INTERNATIONAL_SHIPPING_TRANSFORMER, EbayInternationalShippingTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_SHIPPING_TRANSFORMER, EbayShippingTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_VAULT_PROGRAM_TRANSFORMER, EbayVaultProgramTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_POST_SALE_AUTHENTICATION_PROGRAM_TRANSFORMER, PostSaleAuthenticationProgramTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PROGRAM_TRANSFORMER, ProgramTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_FULFILLMENT_PROGRAM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_INTERNATIONAL_SHIPPING_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_SHIPPING_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_VAULT_PROGRAM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_POST_SALE_AUTHENTICATION_PROGRAM_TRANSFORMER),
                ]
            );
    }
}
