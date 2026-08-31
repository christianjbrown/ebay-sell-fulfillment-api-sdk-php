<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\Tax;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tax::class)]
#[CoversClass(TaxTransformer::class)]
final class TaxTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $amountData = ['__amount__'];

        $amount = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$amountData, $amount],
                ]
            );

        $data = [
            TaxTransformerInterface::KEY_AMOUNT => $amountData,
            TaxTransformerInterface::KEY_TAX_TYPE => 'test-taxType',
        ];

        $transformer = new TaxTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-taxType', $actual->getTaxType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformAmountNotSetCases')]
    public function testTransformAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[TaxTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedTaxType): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedTaxType, $actual->getTaxType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'taxTypeWrongType' => [[TaxTransformerInterface::KEY_TAX_TYPE => 42], null];
    }

    private function buildTransformer(): TaxTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new TaxTransformer($amountTransformer);
    }
}
