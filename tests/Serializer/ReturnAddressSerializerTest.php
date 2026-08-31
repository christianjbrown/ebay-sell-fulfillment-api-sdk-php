<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddress;
use ChristianBrown\EBay\SellFulfillment\Serializer\PhoneSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ReturnAddressSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ReturnAddressSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReturnAddress::class)]
#[CoversClass(ReturnAddressSerializer::class)]
final class ReturnAddressSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $primaryPhoneData = ['__primaryPhone__'];

        $primaryPhone = self::createStub(PhoneInterface::class);

        $phoneSerializer = self::createStub(PhoneSerializerInterface::class);
        $phoneSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$primaryPhone, $primaryPhoneData],
                ]
            );

        $returnAddress = (new ReturnAddress())
            ->setAddressLine1('test-addressLine1')
            ->setAddressLine2('test-addressLine2')
            ->setCity('test-city')
            ->setCountry('test-country')
            ->setCounty('test-county')
            ->setFullName('test-fullName')
            ->setPostalCode('test-postalCode')
            ->setPrimaryPhone($primaryPhone)
            ->setStateOrProvince('test-stateOrProvince');

        $serializer = new ReturnAddressSerializer($phoneSerializer);

        $expected = [
            ReturnAddressSerializerInterface::KEY_ADDRESS_LINE1 => 'test-addressLine1',
            ReturnAddressSerializerInterface::KEY_ADDRESS_LINE2 => 'test-addressLine2',
            ReturnAddressSerializerInterface::KEY_CITY => 'test-city',
            ReturnAddressSerializerInterface::KEY_COUNTRY => 'test-country',
            ReturnAddressSerializerInterface::KEY_COUNTY => 'test-county',
            ReturnAddressSerializerInterface::KEY_FULL_NAME => 'test-fullName',
            ReturnAddressSerializerInterface::KEY_POSTAL_CODE => 'test-postalCode',
            ReturnAddressSerializerInterface::KEY_PRIMARY_PHONE => $primaryPhoneData,
            ReturnAddressSerializerInterface::KEY_STATE_OR_PROVINCE => 'test-stateOrProvince',
        ];

        self::assertSame($expected, $serializer->serialize($returnAddress));
    }

    public function testSerializeEmpty(): void
    {
        $phoneSerializer = self::createStub(PhoneSerializerInterface::class);

        $serializer = new ReturnAddressSerializer($phoneSerializer);

        self::assertSame([], $serializer->serialize(new ReturnAddress()));
    }
}
