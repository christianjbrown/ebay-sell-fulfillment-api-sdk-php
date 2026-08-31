<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Amount;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Amount::class)]
#[CoversClass(AmountTransformer::class)]
final class AmountTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AmountTransformerInterface::KEY_CONVERTED_FROM_CURRENCY => 'test-convertedFromCurrency',
            AmountTransformerInterface::KEY_CONVERTED_FROM_VALUE => 'test-convertedFromValue',
            AmountTransformerInterface::KEY_CURRENCY => 'test-currency',
            AmountTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new AmountTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-convertedFromCurrency', $actual->getConvertedFromCurrency());
        self::assertSame('test-convertedFromValue', $actual->getConvertedFromValue());
        self::assertSame('test-currency', $actual->getCurrency());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedConvertedFromCurrency, ?string $expectedConvertedFromValue, ?string $expectedCurrency, ?string $expectedValue): void
    {
        $transformer = new AmountTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedConvertedFromCurrency, $actual->getConvertedFromCurrency());
        self::assertSame($expectedConvertedFromValue, $actual->getConvertedFromValue());
        self::assertSame($expectedCurrency, $actual->getCurrency());
        self::assertSame($expectedValue, $actual->getValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'convertedFromCurrencyWrongType' => [[AmountTransformerInterface::KEY_CONVERTED_FROM_CURRENCY => 42], null, null, null, null];

        yield 'convertedFromValueWrongType' => [[AmountTransformerInterface::KEY_CONVERTED_FROM_VALUE => 42], null, null, null, null];

        yield 'currencyWrongType' => [[AmountTransformerInterface::KEY_CURRENCY => 42], null, null, null, null];

        yield 'valueWrongType' => [[AmountTransformerInterface::KEY_VALUE => 42], null, null, null, null];
    }
}
