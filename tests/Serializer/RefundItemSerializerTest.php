<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LegacyReferenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\RefundItem;
use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\LegacyReferenceSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\SimpleAmountSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RefundItem::class)]
#[CoversClass(RefundItemSerializer::class)]
final class RefundItemSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $legacyReferenceData = ['__legacyReference__'];
        $refundAmountData = ['__refundAmount__'];

        $legacyReference = self::createStub(LegacyReferenceInterface::class);
        $refundAmount = self::createStub(SimpleAmountInterface::class);

        $legacyReferenceSerializer = self::createStub(LegacyReferenceSerializerInterface::class);
        $legacyReferenceSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$legacyReference, $legacyReferenceData],
                ]
            );
        $simpleAmountSerializer = self::createStub(SimpleAmountSerializerInterface::class);
        $simpleAmountSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$refundAmount, $refundAmountData],
                ]
            );

        $refundItem = (new RefundItem())
            ->setLegacyReference($legacyReference)
            ->setLineItemId('test-lineItemId')
            ->setRefundAmount($refundAmount);

        $serializer = new RefundItemSerializer($legacyReferenceSerializer, $simpleAmountSerializer);

        $expected = [
            RefundItemSerializerInterface::KEY_LEGACY_REFERENCE => $legacyReferenceData,
            RefundItemSerializerInterface::KEY_LINE_ITEM_ID => 'test-lineItemId',
            RefundItemSerializerInterface::KEY_REFUND_AMOUNT => $refundAmountData,
        ];

        self::assertSame($expected, $serializer->serialize($refundItem));
    }

    public function testSerializeEmpty(): void
    {
        $legacyReferenceSerializer = self::createStub(LegacyReferenceSerializerInterface::class);
        $simpleAmountSerializer = self::createStub(SimpleAmountSerializerInterface::class);

        $serializer = new RefundItemSerializer($legacyReferenceSerializer, $simpleAmountSerializer);

        self::assertSame([], $serializer->serialize(new RefundItem()));
    }
}
