<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmount;
use ChristianBrown\EBay\SellFulfillment\Transformer\SimpleAmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SimpleAmountTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SimpleAmount::class)]
#[CoversClass(SimpleAmountTransformer::class)]
final class SimpleAmountTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SimpleAmountTransformerInterface::KEY_CURRENCY => 'test-currency',
            SimpleAmountTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new SimpleAmountTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-currency', $actual->getCurrency());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCurrency, ?string $expectedValue): void
    {
        $transformer = new SimpleAmountTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCurrency, $actual->getCurrency());
        self::assertSame($expectedValue, $actual->getValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'currencyWrongType' => [[SimpleAmountTransformerInterface::KEY_CURRENCY => 42], null, null];

        yield 'valueWrongType' => [[SimpleAmountTransformerInterface::KEY_VALUE => 42], null, null];
    }
}
