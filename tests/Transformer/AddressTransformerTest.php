<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Address;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddressTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Address::class)]
#[CoversClass(AddressTransformer::class)]
final class AddressTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AddressTransformerInterface::KEY_ADDRESS_LINE1 => 'test-addressLine1',
            AddressTransformerInterface::KEY_ADDRESS_LINE2 => 'test-addressLine2',
            AddressTransformerInterface::KEY_CITY => 'test-city',
            AddressTransformerInterface::KEY_COUNTRY_CODE => 'test-countryCode',
            AddressTransformerInterface::KEY_COUNTY => 'test-county',
            AddressTransformerInterface::KEY_POSTAL_CODE => 'test-postalCode',
            AddressTransformerInterface::KEY_STATE_OR_PROVINCE => 'test-stateOrProvince',
        ];

        $transformer = new AddressTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-addressLine1', $actual->getAddressLine1());
        self::assertSame('test-addressLine2', $actual->getAddressLine2());
        self::assertSame('test-city', $actual->getCity());
        self::assertSame('test-countryCode', $actual->getCountryCode());
        self::assertSame('test-county', $actual->getCounty());
        self::assertSame('test-postalCode', $actual->getPostalCode());
        self::assertSame('test-stateOrProvince', $actual->getStateOrProvince());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedAddressLine1, ?string $expectedAddressLine2, ?string $expectedCity, ?string $expectedCountryCode, ?string $expectedCounty, ?string $expectedPostalCode, ?string $expectedStateOrProvince): void
    {
        $transformer = new AddressTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedAddressLine1, $actual->getAddressLine1());
        self::assertSame($expectedAddressLine2, $actual->getAddressLine2());
        self::assertSame($expectedCity, $actual->getCity());
        self::assertSame($expectedCountryCode, $actual->getCountryCode());
        self::assertSame($expectedCounty, $actual->getCounty());
        self::assertSame($expectedPostalCode, $actual->getPostalCode());
        self::assertSame($expectedStateOrProvince, $actual->getStateOrProvince());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null, null];

        yield 'addressLine1WrongType' => [[AddressTransformerInterface::KEY_ADDRESS_LINE1 => 42], null, null, null, null, null, null, null];

        yield 'addressLine2WrongType' => [[AddressTransformerInterface::KEY_ADDRESS_LINE2 => 42], null, null, null, null, null, null, null];

        yield 'cityWrongType' => [[AddressTransformerInterface::KEY_CITY => 42], null, null, null, null, null, null, null];

        yield 'countryCodeWrongType' => [[AddressTransformerInterface::KEY_COUNTRY_CODE => 42], null, null, null, null, null, null, null];

        yield 'countyWrongType' => [[AddressTransformerInterface::KEY_COUNTY => 42], null, null, null, null, null, null, null];

        yield 'postalCodeWrongType' => [[AddressTransformerInterface::KEY_POSTAL_CODE => 42], null, null, null, null, null, null, null];

        yield 'stateOrProvinceWrongType' => [[AddressTransformerInterface::KEY_STATE_OR_PROVINCE => 42], null, null, null, null, null, null, null];
    }
}
