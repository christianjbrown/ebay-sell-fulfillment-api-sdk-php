<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\RefundItemInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemsSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RefundItemsSerializer::class)]
final class RefundItemsSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $first = self::createStub(RefundItemInterface::class);
        $second = self::createStub(RefundItemInterface::class);

        $refundItemSerializer = self::createStub(RefundItemSerializerInterface::class);
        $refundItemSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$first, ['first' => 'test-1']],
                    [$second, ['second' => 'test-2']],
                ]
            );

        $serializer = new RefundItemsSerializer($refundItemSerializer);

        self::assertSame([['first' => 'test-1'], ['second' => 'test-2']], $serializer->serialize([$first, $second]));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new RefundItemsSerializer(self::createStub(RefundItemSerializerInterface::class));

        self::assertSame([], $serializer->serialize([]));
    }
}
