<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Registrar;

use ChristianBrown\ApiClient\ApiClientInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\ApplicationCredentials;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderBuyerTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderCancelTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderFulfillmentInstructionTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderLineItemTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderPricingTransformerRegistrar;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\Lock\NullLock;
use ChristianBrown\OAuth2Client\RefreshTokenManagerFactoryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(OrderLineItemTransformerRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApplicationCredentials::class)]
#[UsesClass(CoreServiceRegistrar::class)]
#[UsesClass(OrderBuyerTransformerRegistrar::class)]
#[UsesClass(OrderCancelTransformerRegistrar::class)]
#[UsesClass(OrderFulfillmentInstructionTransformerRegistrar::class)]
#[UsesClass(OrderPricingTransformerRegistrar::class)]
final class OrderLineItemTransformerRegistrarTest extends TestCase
{
    public function testRegisterWiresTheGroup(): void
    {
        $container = new ContainerBuilder();

        (new CoreServiceRegistrar(
            new ApplicationCredentials('test-client-id', 'test-client-secret', CredentialsInterface::MARKETPLACE_ID_EBAY_GB),
            self::createStub(ApiClientInterface::class),
            self::createStub(RefreshTokenManagerFactoryInterface::class),
            self::createStub(TtlAwareKeyValueStoreInterface::class),
            self::createStub(KeyValueStoreInterface::class),
            new NullLock(),
            new ApiHost(),
        ))->register($container);
        (new OrderPricingTransformerRegistrar())->register($container);
        (new OrderBuyerTransformerRegistrar())->register($container);
        (new OrderCancelTransformerRegistrar())->register($container);
        (new OrderFulfillmentInstructionTransformerRegistrar())->register($container);
        (new OrderLineItemTransformerRegistrar())->register($container);

        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_LINE_ITEMS_TRANSFORMER));
    }
}
