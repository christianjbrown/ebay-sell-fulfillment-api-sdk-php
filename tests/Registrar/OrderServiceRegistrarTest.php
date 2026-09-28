<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Registrar;

use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(OrderServiceRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreServiceRegistrar::class)]
final class OrderServiceRegistrarTest extends TestCase
{
    public function testRegisterWiresTheOrderApi(): void
    {
        $apiHost = new ApiHost();
        $container = new ContainerBuilder();

        (new CoreServiceRegistrar(
            'test-client-id',
            'test-client-secret',
            CredentialsInterface::MARKETPLACE_ID_EBAY_GB,
            self::createStub(TtlAwareKeyValueStoreInterface::class),
            self::createStub(KeyValueStoreInterface::class),
            null,
            $apiHost,
        ))->register($container);

        (new OrderServiceRegistrar($apiHost))->register($container);

        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_ORDER_API));
    }
}
