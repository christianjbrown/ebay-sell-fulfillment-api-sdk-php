<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefund;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineItemRefund::class)]
#[CoversClass(LineItemRefundTransformer::class)]
final class LineItemRefundTransformerTest extends TestCase
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
            LineItemRefundTransformerInterface::KEY_AMOUNT => $amountData,
            LineItemRefundTransformerInterface::KEY_REFUND_DATE => 'test-refundDate',
            LineItemRefundTransformerInterface::KEY_REFUND_ID => 'test-refundId',
            LineItemRefundTransformerInterface::KEY_REFUND_REFERENCE_ID => 'test-refundReferenceId',
        ];

        $transformer = new LineItemRefundTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-refundDate', $actual->getRefundDate());
        self::assertSame('test-refundId', $actual->getRefundId());
        self::assertSame('test-refundReferenceId', $actual->getRefundReferenceId());
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

        yield 'nonArray' => [[LineItemRefundTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedRefundDate, ?string $expectedRefundId, ?string $expectedRefundReferenceId): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedRefundDate, $actual->getRefundDate());
        self::assertSame($expectedRefundId, $actual->getRefundId());
        self::assertSame($expectedRefundReferenceId, $actual->getRefundReferenceId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'refundDateWrongType' => [[LineItemRefundTransformerInterface::KEY_REFUND_DATE => 42], null, null, null];

        yield 'refundIdWrongType' => [[LineItemRefundTransformerInterface::KEY_REFUND_ID => 42], null, null, null];

        yield 'refundReferenceIdWrongType' => [[LineItemRefundTransformerInterface::KEY_REFUND_REFERENCE_ID => 42], null, null, null];
    }

    private function buildTransformer(): LineItemRefundTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new LineItemRefundTransformer($amountTransformer);
    }
}
