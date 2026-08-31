<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeAmount;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeAmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeAmountTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DisputeAmount::class)]
#[CoversClass(DisputeAmountTransformer::class)]
final class DisputeAmountTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DisputeAmountTransformerInterface::KEY_CONVERTED_FROM_CURRENCY => 'test-convertedFromCurrency',
            DisputeAmountTransformerInterface::KEY_CONVERTED_FROM_VALUE => 'test-convertedFromValue',
            DisputeAmountTransformerInterface::KEY_CURRENCY => 'test-currency',
            DisputeAmountTransformerInterface::KEY_EXCHANGE_RATE => 'test-exchangeRate',
            DisputeAmountTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new DisputeAmountTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-convertedFromCurrency', $actual->getConvertedFromCurrency());
        self::assertSame('test-convertedFromValue', $actual->getConvertedFromValue());
        self::assertSame('test-currency', $actual->getCurrency());
        self::assertSame('test-exchangeRate', $actual->getExchangeRate());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedConvertedFromCurrency, ?string $expectedConvertedFromValue, ?string $expectedCurrency, ?string $expectedExchangeRate, ?string $expectedValue): void
    {
        $transformer = new DisputeAmountTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedConvertedFromCurrency, $actual->getConvertedFromCurrency());
        self::assertSame($expectedConvertedFromValue, $actual->getConvertedFromValue());
        self::assertSame($expectedCurrency, $actual->getCurrency());
        self::assertSame($expectedExchangeRate, $actual->getExchangeRate());
        self::assertSame($expectedValue, $actual->getValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null];

        yield 'convertedFromCurrencyWrongType' => [[DisputeAmountTransformerInterface::KEY_CONVERTED_FROM_CURRENCY => 42], null, null, null, null, null];

        yield 'convertedFromValueWrongType' => [[DisputeAmountTransformerInterface::KEY_CONVERTED_FROM_VALUE => 42], null, null, null, null, null];

        yield 'currencyWrongType' => [[DisputeAmountTransformerInterface::KEY_CURRENCY => 42], null, null, null, null, null];

        yield 'exchangeRateWrongType' => [[DisputeAmountTransformerInterface::KEY_EXCHANGE_RATE => 42], null, null, null, null, null];

        yield 'valueWrongType' => [[DisputeAmountTransformerInterface::KEY_VALUE => 42], null, null, null, null, null];
    }
}
