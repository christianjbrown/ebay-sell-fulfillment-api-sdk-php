<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillment;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferencesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShippingFulfillment::class)]
#[CoversClass(ShippingFulfillmentTransformer::class)]
final class ShippingFulfillmentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $lineItemsData = ['__lineItems__'];

        $lineItems = [self::createStub(LineItemReferenceInterface::class)];

        $lineItemReferencesTransformer = self::createStub(LineItemReferencesTransformerInterface::class);
        $lineItemReferencesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$lineItemsData, $lineItems],
                ]
            );

        $data = [
            ShippingFulfillmentTransformerInterface::KEY_FULFILLMENT_ID => 'test-fulfillmentId',
            ShippingFulfillmentTransformerInterface::KEY_LINE_ITEMS => $lineItemsData,
            ShippingFulfillmentTransformerInterface::KEY_SHIPMENT_TRACKING_NUMBER => 'test-shipmentTrackingNumber',
            ShippingFulfillmentTransformerInterface::KEY_SHIPPED_DATE => 'test-shippedDate',
            ShippingFulfillmentTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 'test-shippingCarrierCode',
        ];

        $transformer = new ShippingFulfillmentTransformer($lineItemReferencesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-fulfillmentId', $actual->getFulfillmentId());
        self::assertSame($lineItems, $actual->getLineItems());
        self::assertSame('test-shipmentTrackingNumber', $actual->getShipmentTrackingNumber());
        self::assertSame('test-shippedDate', $actual->getShippedDate());
        self::assertSame('test-shippingCarrierCode', $actual->getShippingCarrierCode());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLineItemsNotSetCases')]
    public function testTransformLineItemsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getLineItems());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLineItemsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ShippingFulfillmentTransformerInterface::KEY_LINE_ITEMS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedFulfillmentId, ?string $expectedShipmentTrackingNumber, ?string $expectedShippedDate, ?string $expectedShippingCarrierCode): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedFulfillmentId, $actual->getFulfillmentId());
        self::assertSame($expectedShipmentTrackingNumber, $actual->getShipmentTrackingNumber());
        self::assertSame($expectedShippedDate, $actual->getShippedDate());
        self::assertSame($expectedShippingCarrierCode, $actual->getShippingCarrierCode());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'fulfillmentIdWrongType' => [[ShippingFulfillmentTransformerInterface::KEY_FULFILLMENT_ID => 42], null, null, null, null];

        yield 'shipmentTrackingNumberWrongType' => [[ShippingFulfillmentTransformerInterface::KEY_SHIPMENT_TRACKING_NUMBER => 42], null, null, null, null];

        yield 'shippedDateWrongType' => [[ShippingFulfillmentTransformerInterface::KEY_SHIPPED_DATE => 42], null, null, null, null];

        yield 'shippingCarrierCodeWrongType' => [[ShippingFulfillmentTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 42], null, null, null, null];
    }

    private function buildTransformer(): ShippingFulfillmentTransformer
    {
        $lineItemReferencesTransformer = self::createStub(LineItemReferencesTransformerInterface::class);

        return new ShippingFulfillmentTransformer($lineItemReferencesTransformer);
    }
}
