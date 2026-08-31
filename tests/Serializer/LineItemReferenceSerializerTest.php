<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReference;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferenceSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineItemReference::class)]
#[CoversClass(LineItemReferenceSerializer::class)]
final class LineItemReferenceSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $lineItemReference = (new LineItemReference())
            ->setLineItemId('test-lineItemId')
            ->setQuantity(42);

        $serializer = new LineItemReferenceSerializer();

        $expected = [
            LineItemReferenceSerializerInterface::KEY_LINE_ITEM_ID => 'test-lineItemId',
            LineItemReferenceSerializerInterface::KEY_QUANTITY => 42,
        ];

        self::assertSame($expected, $serializer->serialize($lineItemReference));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new LineItemReferenceSerializer();

        self::assertSame([], $serializer->serialize(new LineItemReference()));
    }
}
