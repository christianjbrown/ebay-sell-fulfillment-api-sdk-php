<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests;

use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApiInterface;
use ChristianBrown\EBay\SellFulfillment\SellFulfillment;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

#[CoversClass(SellFulfillment::class)]
final class SellFulfillmentTest extends TestCase
{
    public function testGetOrderApi(): void
    {
        $api = self::createStub(OrderApiInterface::class);

        self::assertSame($api, $this->facadeServing(SellFulfillmentInterface::SERVICE_ORDER_API, $api)->getOrderApi());
    }

    public function testGetPaymentDisputeApi(): void
    {
        $api = self::createStub(PaymentDisputeApiInterface::class);

        self::assertSame($api, $this->facadeServing(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_API, $api)->getPaymentDisputeApi());
    }

    public function testGetPaymentDisputeEvidenceApi(): void
    {
        $api = self::createStub(PaymentDisputeEvidenceApiInterface::class);

        self::assertSame($api, $this->facadeServing(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_EVIDENCE_API, $api)->getPaymentDisputeEvidenceApi());
    }

    public function testGetShippingFulfillmentApi(): void
    {
        $api = self::createStub(ShippingFulfillmentApiInterface::class);

        self::assertSame($api, $this->facadeServing(SellFulfillmentInterface::SERVICE_SHIPPING_FULFILLMENT_API, $api)->getShippingFulfillmentApi());
    }

    private function facadeServing(string $id, object $service): SellFulfillment
    {
        $container = self::createMock(ContainerInterface::class);
        $container->expects(self::once())->method('get')->with($id)->willReturn($service);

        return new SellFulfillment($container);
    }
}
