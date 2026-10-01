<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Registrar;

use ChristianBrown\EBay\SellFulfillment\Auth\ApplicationCredentials;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderBuyerTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderPricingTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(OrderBuyerTransformerRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApplicationCredentials::class)]
#[UsesClass(CoreServiceRegistrar::class)]
#[UsesClass(OrderPricingTransformerRegistrar::class)]
final class OrderBuyerTransformerRegistrarTest extends TestCase
{
    public function testRegisterWiresTheGroup(): void
    {
        $container = new ContainerBuilder();

        (new CoreServiceRegistrar(
            new ApplicationCredentials('test-client-id', 'test-client-secret', CredentialsInterface::MARKETPLACE_ID_EBAY_GB),
            self::createStub(TtlAwareKeyValueStoreInterface::class),
            self::createStub(KeyValueStoreInterface::class),
            null,
            new ApiHost(),
        ))->register($container);
        (new OrderPricingTransformerRegistrar())->register($container);
        (new OrderBuyerTransformerRegistrar())->register($container);

        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_BUYER_TRANSFORMER));
    }
}
