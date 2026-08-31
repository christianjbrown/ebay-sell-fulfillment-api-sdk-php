<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItem;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderLineItem::class)]
#[CoversClass(OrderLineItemSerializer::class)]
final class OrderLineItemSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $orderLineItem = (new OrderLineItem())
            ->setItemId('test-itemId')
            ->setLineItemId('test-lineItemId');

        $serializer = new OrderLineItemSerializer();

        $expected = [
            OrderLineItemSerializerInterface::KEY_ITEM_ID => 'test-itemId',
            OrderLineItemSerializerInterface::KEY_LINE_ITEM_ID => 'test-lineItemId',
        ];

        self::assertSame($expected, $serializer->serialize($orderLineItem));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new OrderLineItemSerializer();

        self::assertSame([], $serializer->serialize(new OrderLineItem()));
    }
}
