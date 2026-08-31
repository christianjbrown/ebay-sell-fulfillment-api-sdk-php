<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemsSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderLineItemsSerializer::class)]
final class OrderLineItemsSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $first = self::createStub(OrderLineItemInterface::class);
        $second = self::createStub(OrderLineItemInterface::class);

        $orderLineItemSerializer = self::createStub(OrderLineItemSerializerInterface::class);
        $orderLineItemSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$first, ['first' => 'test-1']],
                    [$second, ['second' => 'test-2']],
                ]
            );

        $serializer = new OrderLineItemsSerializer($orderLineItemSerializer);

        self::assertSame([['first' => 'test-1'], ['second' => 'test-2']], $serializer->serialize([$first, $second]));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new OrderLineItemsSerializer(self::createStub(OrderLineItemSerializerInterface::class));

        self::assertSame([], $serializer->serialize([]));
    }
}
