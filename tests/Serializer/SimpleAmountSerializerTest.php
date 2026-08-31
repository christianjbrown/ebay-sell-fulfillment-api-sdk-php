<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmount;
use ChristianBrown\EBay\SellFulfillment\Serializer\SimpleAmountSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\SimpleAmountSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SimpleAmount::class)]
#[CoversClass(SimpleAmountSerializer::class)]
final class SimpleAmountSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $simpleAmount = (new SimpleAmount())
            ->setCurrency('test-currency')
            ->setValue('test-value');

        $serializer = new SimpleAmountSerializer();

        $expected = [
            SimpleAmountSerializerInterface::KEY_CURRENCY => 'test-currency',
            SimpleAmountSerializerInterface::KEY_VALUE => 'test-value',
        ];

        self::assertSame($expected, $serializer->serialize($simpleAmount));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new SimpleAmountSerializer();

        self::assertSame([], $serializer->serialize(new SimpleAmount()));
    }
}
