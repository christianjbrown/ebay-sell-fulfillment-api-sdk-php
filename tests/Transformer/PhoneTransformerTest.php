<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Phone;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Phone::class)]
#[CoversClass(PhoneTransformer::class)]
final class PhoneTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PhoneTransformerInterface::KEY_COUNTRY_CODE => 'test-countryCode',
            PhoneTransformerInterface::KEY_NUMBER => 'test-number',
        ];

        $transformer = new PhoneTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-countryCode', $actual->getCountryCode());
        self::assertSame('test-number', $actual->getNumber());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCountryCode, ?string $expectedNumber): void
    {
        $transformer = new PhoneTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCountryCode, $actual->getCountryCode());
        self::assertSame($expectedNumber, $actual->getNumber());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'countryCodeWrongType' => [[PhoneTransformerInterface::KEY_COUNTRY_CODE => 42], null, null];

        yield 'numberWrongType' => [[PhoneTransformerInterface::KEY_NUMBER => 42], null, null];
    }
}
