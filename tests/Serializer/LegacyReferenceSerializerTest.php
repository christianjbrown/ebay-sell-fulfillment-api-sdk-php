<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LegacyReference;
use ChristianBrown\EBay\SellFulfillment\Serializer\LegacyReferenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LegacyReferenceSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LegacyReference::class)]
#[CoversClass(LegacyReferenceSerializer::class)]
final class LegacyReferenceSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $legacyReference = (new LegacyReference())
            ->setLegacyItemId('test-legacyItemId')
            ->setLegacyTransactionId('test-legacyTransactionId');

        $serializer = new LegacyReferenceSerializer();

        $expected = [
            LegacyReferenceSerializerInterface::KEY_LEGACY_ITEM_ID => 'test-legacyItemId',
            LegacyReferenceSerializerInterface::KEY_LEGACY_TRANSACTION_ID => 'test-legacyTransactionId',
        ];

        self::assertSame($expected, $serializer->serialize($legacyReference));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new LegacyReferenceSerializer();

        self::assertSame([], $serializer->serialize(new LegacyReference()));
    }
}
