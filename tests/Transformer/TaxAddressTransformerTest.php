<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxAddress;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxAddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxAddressTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TaxAddress::class)]
#[CoversClass(TaxAddressTransformer::class)]
final class TaxAddressTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TaxAddressTransformerInterface::KEY_CITY => 'test-city',
            TaxAddressTransformerInterface::KEY_COUNTRY_CODE => 'test-countryCode',
            TaxAddressTransformerInterface::KEY_POSTAL_CODE => 'test-postalCode',
            TaxAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 'test-stateOrProvince',
        ];

        $transformer = new TaxAddressTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-city', $actual->getCity());
        self::assertSame('test-countryCode', $actual->getCountryCode());
        self::assertSame('test-postalCode', $actual->getPostalCode());
        self::assertSame('test-stateOrProvince', $actual->getStateOrProvince());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCity, ?string $expectedCountryCode, ?string $expectedPostalCode, ?string $expectedStateOrProvince): void
    {
        $transformer = new TaxAddressTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCity, $actual->getCity());
        self::assertSame($expectedCountryCode, $actual->getCountryCode());
        self::assertSame($expectedPostalCode, $actual->getPostalCode());
        self::assertSame($expectedStateOrProvince, $actual->getStateOrProvince());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'cityWrongType' => [[TaxAddressTransformerInterface::KEY_CITY => 42], null, null, null, null];

        yield 'countryCodeWrongType' => [[TaxAddressTransformerInterface::KEY_COUNTRY_CODE => 42], null, null, null, null];

        yield 'postalCodeWrongType' => [[TaxAddressTransformerInterface::KEY_POSTAL_CODE => 42], null, null, null, null];

        yield 'stateOrProvinceWrongType' => [[TaxAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 42], null, null, null, null];
    }
}
