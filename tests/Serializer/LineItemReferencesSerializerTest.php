<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferenceSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferencesSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineItemReferencesSerializer::class)]
final class LineItemReferencesSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $first = self::createStub(LineItemReferenceInterface::class);
        $second = self::createStub(LineItemReferenceInterface::class);

        $lineItemReferenceSerializer = self::createStub(LineItemReferenceSerializerInterface::class);
        $lineItemReferenceSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$first, ['first' => 'test-1']],
                    [$second, ['second' => 'test-2']],
                ]
            );

        $serializer = new LineItemReferencesSerializer($lineItemReferenceSerializer);

        self::assertSame([['first' => 'test-1'], ['second' => 'test-2']], $serializer->serialize([$first, $second]));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new LineItemReferencesSerializer(self::createStub(LineItemReferenceSerializerInterface::class));

        self::assertSame([], $serializer->serialize([]));
    }
}
