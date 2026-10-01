<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Registrar;

use ChristianBrown\EBay\SellFulfillment\Auth\ApplicationCredentials;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CoreServiceRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApplicationCredentials::class)]
final class CoreServiceRegistrarTest extends TestCase
{
    public function testRegisterWiresAuthAndSharedTransformers(): void
    {
        $registrar = new CoreServiceRegistrar(
            new ApplicationCredentials('test-client-id', 'test-client-secret', CredentialsInterface::MARKETPLACE_ID_EBAY_GB),
            self::createStub(TtlAwareKeyValueStoreInterface::class),
            self::createStub(KeyValueStoreInterface::class),
            null,
            new ApiHost(),
        );

        $container = new ContainerBuilder();
        $registrar->register($container);

        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_CREDENTIALS));
        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD));
        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_ERRORS_TRANSFORMER));
        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_TRACKING_INFOS_TRANSFORMER));
    }
}
