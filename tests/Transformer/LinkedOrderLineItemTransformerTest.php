<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItem;
use ChristianBrown\EBay\SellFulfillment\Model\NameValuePairInterface;
use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfosTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LinkedOrderLineItem::class)]
#[CoversClass(LinkedOrderLineItemTransformer::class)]
final class LinkedOrderLineItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $lineItemAspectsData = ['__lineItemAspects__'];
        $shipmentsData = ['__shipments__'];

        $lineItemAspects = [self::createStub(NameValuePairInterface::class)];
        $shipments = [self::createStub(TrackingInfoInterface::class)];

        $nameValuePairsTransformer = self::createStub(NameValuePairsTransformerInterface::class);
        $nameValuePairsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$lineItemAspectsData, $lineItemAspects],
                ]
            );
        $trackingInfosTransformer = self::createStub(TrackingInfosTransformerInterface::class);
        $trackingInfosTransformer->method('transform')
            ->willReturnMap(
                [
                    [$shipmentsData, $shipments],
                ]
            );

        $data = [
            LinkedOrderLineItemTransformerInterface::KEY_LINE_ITEM_ASPECTS => $lineItemAspectsData,
            LinkedOrderLineItemTransformerInterface::KEY_LINE_ITEM_ID => 'test-lineItemId',
            LinkedOrderLineItemTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 'test-maxEstimatedDeliveryDate',
            LinkedOrderLineItemTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 'test-minEstimatedDeliveryDate',
            LinkedOrderLineItemTransformerInterface::KEY_ORDER_ID => 'test-orderId',
            LinkedOrderLineItemTransformerInterface::KEY_SELLER_ID => 'test-sellerId',
            LinkedOrderLineItemTransformerInterface::KEY_SHIPMENTS => $shipmentsData,
            LinkedOrderLineItemTransformerInterface::KEY_TITLE => 'test-title',
        ];

        $transformer = new LinkedOrderLineItemTransformer($nameValuePairsTransformer, $trackingInfosTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($lineItemAspects, $actual->getLineItemAspects());
        self::assertSame('test-lineItemId', $actual->getLineItemId());
        self::assertSame('test-maxEstimatedDeliveryDate', $actual->getMaxEstimatedDeliveryDate());
        self::assertSame('test-minEstimatedDeliveryDate', $actual->getMinEstimatedDeliveryDate());
        self::assertSame('test-orderId', $actual->getOrderId());
        self::assertSame('test-sellerId', $actual->getSellerId());
        self::assertSame($shipments, $actual->getShipments());
        self::assertSame('test-title', $actual->getTitle());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLineItemAspectsNotSetCases')]
    public function testTransformLineItemAspectsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getLineItemAspects());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLineItemAspectsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LinkedOrderLineItemTransformerInterface::KEY_LINE_ITEM_ASPECTS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedLineItemId, ?string $expectedMaxEstimatedDeliveryDate, ?string $expectedMinEstimatedDeliveryDate, ?string $expectedOrderId, ?string $expectedSellerId, ?string $expectedTitle): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedLineItemId, $actual->getLineItemId());
        self::assertSame($expectedMaxEstimatedDeliveryDate, $actual->getMaxEstimatedDeliveryDate());
        self::assertSame($expectedMinEstimatedDeliveryDate, $actual->getMinEstimatedDeliveryDate());
        self::assertSame($expectedOrderId, $actual->getOrderId());
        self::assertSame($expectedSellerId, $actual->getSellerId());
        self::assertSame($expectedTitle, $actual->getTitle());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null];

        yield 'lineItemIdWrongType' => [[LinkedOrderLineItemTransformerInterface::KEY_LINE_ITEM_ID => 42], null, null, null, null, null, null];

        yield 'maxEstimatedDeliveryDateWrongType' => [[LinkedOrderLineItemTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 42], null, null, null, null, null, null];

        yield 'minEstimatedDeliveryDateWrongType' => [[LinkedOrderLineItemTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 42], null, null, null, null, null, null];

        yield 'orderIdWrongType' => [[LinkedOrderLineItemTransformerInterface::KEY_ORDER_ID => 42], null, null, null, null, null, null];

        yield 'sellerIdWrongType' => [[LinkedOrderLineItemTransformerInterface::KEY_SELLER_ID => 42], null, null, null, null, null, null];

        yield 'titleWrongType' => [[LinkedOrderLineItemTransformerInterface::KEY_TITLE => 42], null, null, null, null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformShipmentsNotSetCases')]
    public function testTransformShipmentsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getShipments());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformShipmentsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LinkedOrderLineItemTransformerInterface::KEY_SHIPMENTS => 'not-an-array']];
    }

    private function buildTransformer(): LinkedOrderLineItemTransformer
    {
        $nameValuePairsTransformer = self::createStub(NameValuePairsTransformerInterface::class);
        $trackingInfosTransformer = self::createStub(TrackingInfosTransformerInterface::class);

        return new LinkedOrderLineItemTransformer($nameValuePairsTransformer, $trackingInfosTransformer);
    }
}
