<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\IssueRefundRequest;
use ChristianBrown\EBay\SellFulfillment\Model\RefundItemInterface;
use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\IssueRefundRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\IssueRefundRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemsSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\SimpleAmountSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IssueRefundRequest::class)]
#[CoversClass(IssueRefundRequestSerializer::class)]
final class IssueRefundRequestSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $orderLevelRefundAmountData = ['__orderLevelRefundAmount__'];
        $refundItemsData = ['__refundItems__'];

        $orderLevelRefundAmount = self::createStub(SimpleAmountInterface::class);
        $refundItems = [self::createStub(RefundItemInterface::class)];

        $refundItemsSerializer = self::createStub(RefundItemsSerializerInterface::class);
        $refundItemsSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$refundItems, $refundItemsData],
                ]
            );
        $simpleAmountSerializer = self::createStub(SimpleAmountSerializerInterface::class);
        $simpleAmountSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$orderLevelRefundAmount, $orderLevelRefundAmountData],
                ]
            );

        $issueRefundRequest = (new IssueRefundRequest())
            ->setComment('test-comment')
            ->setOrderLevelRefundAmount($orderLevelRefundAmount)
            ->setReasonForRefund('test-reasonForRefund')
            ->setRefundItems($refundItems);

        $serializer = new IssueRefundRequestSerializer($refundItemsSerializer, $simpleAmountSerializer);

        $expected = [
            IssueRefundRequestSerializerInterface::KEY_COMMENT => 'test-comment',
            IssueRefundRequestSerializerInterface::KEY_ORDER_LEVEL_REFUND_AMOUNT => $orderLevelRefundAmountData,
            IssueRefundRequestSerializerInterface::KEY_REASON_FOR_REFUND => 'test-reasonForRefund',
            IssueRefundRequestSerializerInterface::KEY_REFUND_ITEMS => $refundItemsData,
        ];

        self::assertSame($expected, $serializer->serialize($issueRefundRequest));
    }

    public function testSerializeEmpty(): void
    {
        $refundItemsSerializer = self::createStub(RefundItemsSerializerInterface::class);
        $simpleAmountSerializer = self::createStub(SimpleAmountSerializerInterface::class);

        $serializer = new IssueRefundRequestSerializer($refundItemsSerializer, $simpleAmountSerializer);

        self::assertSame([], $serializer->serialize(new IssueRefundRequest()));
    }
}
