<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfo;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfoTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfoTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TrackingInfo::class)]
#[CoversClass(TrackingInfoTransformer::class)]
final class TrackingInfoTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TrackingInfoTransformerInterface::KEY_SHIPMENT_TRACKING_NUMBER => 'test-shipmentTrackingNumber',
            TrackingInfoTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 'test-shippingCarrierCode',
        ];

        $transformer = new TrackingInfoTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-shipmentTrackingNumber', $actual->getShipmentTrackingNumber());
        self::assertSame('test-shippingCarrierCode', $actual->getShippingCarrierCode());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedShipmentTrackingNumber, ?string $expectedShippingCarrierCode): void
    {
        $transformer = new TrackingInfoTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedShipmentTrackingNumber, $actual->getShipmentTrackingNumber());
        self::assertSame($expectedShippingCarrierCode, $actual->getShippingCarrierCode());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'shipmentTrackingNumberWrongType' => [[TrackingInfoTransformerInterface::KEY_SHIPMENT_TRACKING_NUMBER => 42], null, null];

        yield 'shippingCarrierCodeWrongType' => [[TrackingInfoTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 42], null, null];
    }
}
