<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Registrar;

use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\PaymentDisputeServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(PaymentDisputeServiceRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreServiceRegistrar::class)]
final class PaymentDisputeServiceRegistrarTest extends TestCase
{
    public function testRegisterWiresThePaymentDisputeApi(): void
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

        (new PaymentDisputeServiceRegistrar($apiHost))->register($container);

        self::assertTrue($container->has(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_API));
    }
}
