<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeAmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransaction;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeAmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MonetaryTransaction::class)]
#[CoversClass(MonetaryTransactionTransformer::class)]
final class MonetaryTransactionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $amountData = ['__amount__'];

        $amount = self::createStub(DisputeAmountInterface::class);

        $disputeAmountTransformer = self::createStub(DisputeAmountTransformerInterface::class);
        $disputeAmountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$amountData, $amount],
                ]
            );

        $data = [
            MonetaryTransactionTransformerInterface::KEY_AMOUNT => $amountData,
            MonetaryTransactionTransformerInterface::KEY_DATE => 'test-date',
            MonetaryTransactionTransformerInterface::KEY_REASON => 'test-reason',
            MonetaryTransactionTransformerInterface::KEY_TYPE => 'test-type',
        ];

        $transformer = new MonetaryTransactionTransformer($disputeAmountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-date', $actual->getDate());
        self::assertSame('test-reason', $actual->getReason());
        self::assertSame('test-type', $actual->getType());
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

        yield 'nonArray' => [[MonetaryTransactionTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedDate, ?string $expectedReason, ?string $expectedType): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedDate, $actual->getDate());
        self::assertSame($expectedReason, $actual->getReason());
        self::assertSame($expectedType, $actual->getType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'dateWrongType' => [[MonetaryTransactionTransformerInterface::KEY_DATE => 42], null, null, null];

        yield 'reasonWrongType' => [[MonetaryTransactionTransformerInterface::KEY_REASON => 42], null, null, null];

        yield 'typeWrongType' => [[MonetaryTransactionTransformerInterface::KEY_TYPE => 42], null, null, null];
    }

    private function buildTransformer(): MonetaryTransactionTransformer
    {
        $disputeAmountTransformer = self::createStub(DisputeAmountTransformerInterface::class);

        return new MonetaryTransactionTransformer($disputeAmountTransformer);
    }
}
