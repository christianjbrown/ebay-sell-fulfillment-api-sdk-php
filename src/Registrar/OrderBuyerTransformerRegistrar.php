<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\BuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ExtendedContactTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneNumberTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxAddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxIdentifierTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order address, phone, contact and buyer transformers. Must run after {@see CoreServiceRegistrar} and {@see OrderPricingTransformerRegistrar}.
 */
final class OrderBuyerTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_ADDRESS_TRANSFORMER, AddressTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PHONE_NUMBER_TRANSFORMER, PhoneNumberTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EXTENDED_CONTACT_TRANSFORMER, ExtendedContactTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ADDRESS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PHONE_NUMBER_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_TAX_ADDRESS_TRANSFORMER, TaxAddressTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_TAX_IDENTIFIER_TRANSFORMER, TaxIdentifierTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_BUYER_TRANSFORMER, BuyerTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EXTENDED_CONTACT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAX_ADDRESS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAX_IDENTIFIER_TRANSFORMER),
                ]
            );
    }
}
