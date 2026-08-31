<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ItemLocation;
use ChristianBrown\EBay\SellFulfillment\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ItemLocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemLocation::class)]
#[CoversClass(ItemLocationTransformer::class)]
final class ItemLocationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ItemLocationTransformerInterface::KEY_COUNTRY_CODE => 'test-countryCode',
            ItemLocationTransformerInterface::KEY_LOCATION => 'test-location',
            ItemLocationTransformerInterface::KEY_POSTAL_CODE => 'test-postalCode',
        ];

        $transformer = new ItemLocationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-countryCode', $actual->getCountryCode());
        self::assertSame('test-location', $actual->getLocation());
        self::assertSame('test-postalCode', $actual->getPostalCode());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCountryCode, ?string $expectedLocation, ?string $expectedPostalCode): void
    {
        $transformer = new ItemLocationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCountryCode, $actual->getCountryCode());
        self::assertSame($expectedLocation, $actual->getLocation());
        self::assertSame($expectedPostalCode, $actual->getPostalCode());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'countryCodeWrongType' => [[ItemLocationTransformerInterface::KEY_COUNTRY_CODE => 42], null, null, null];

        yield 'locationWrongType' => [[ItemLocationTransformerInterface::KEY_LOCATION => 42], null, null, null];

        yield 'postalCodeWrongType' => [[ItemLocationTransformerInterface::KEY_POSTAL_CODE => 42], null, null, null];
    }
}
