<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\Phone;
use ChristianBrown\EBay\SellFulfillment\Serializer\PhoneSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\PhoneSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Phone::class)]
#[CoversClass(PhoneSerializer::class)]
final class PhoneSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $phone = (new Phone())
            ->setCountryCode('test-countryCode')
            ->setNumber('test-number');

        $serializer = new PhoneSerializer();

        $expected = [
            PhoneSerializerInterface::KEY_COUNTRY_CODE => 'test-countryCode',
            PhoneSerializerInterface::KEY_NUMBER => 'test-number',
        ];

        self::assertSame($expected, $serializer->serialize($phone));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new PhoneSerializer();

        self::assertSame([], $serializer->serialize(new Phone()));
    }
}
