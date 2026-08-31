<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderRefund;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderRefund::class)]
#[CoversClass(OrderRefundTransformer::class)]
final class OrderRefundTransformerTest extends TestCase
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
            OrderRefundTransformerInterface::KEY_AMOUNT => $amountData,
            OrderRefundTransformerInterface::KEY_REFUND_DATE => 'test-refundDate',
            OrderRefundTransformerInterface::KEY_REFUND_ID => 'test-refundId',
            OrderRefundTransformerInterface::KEY_REFUND_REFERENCE_ID => 'test-refundReferenceId',
            OrderRefundTransformerInterface::KEY_REFUND_STATUS => 'test-refundStatus',
        ];

        $transformer = new OrderRefundTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-refundDate', $actual->getRefundDate());
        self::assertSame('test-refundId', $actual->getRefundId());
        self::assertSame('test-refundReferenceId', $actual->getRefundReferenceId());
        self::assertSame('test-refundStatus', $actual->getRefundStatus());
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

        yield 'nonArray' => [[OrderRefundTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedRefundDate, ?string $expectedRefundId, ?string $expectedRefundReferenceId, ?string $expectedRefundStatus): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedRefundDate, $actual->getRefundDate());
        self::assertSame($expectedRefundId, $actual->getRefundId());
        self::assertSame($expectedRefundReferenceId, $actual->getRefundReferenceId());
        self::assertSame($expectedRefundStatus, $actual->getRefundStatus());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'refundDateWrongType' => [[OrderRefundTransformerInterface::KEY_REFUND_DATE => 42], null, null, null, null];

        yield 'refundIdWrongType' => [[OrderRefundTransformerInterface::KEY_REFUND_ID => 42], null, null, null, null];

        yield 'refundReferenceIdWrongType' => [[OrderRefundTransformerInterface::KEY_REFUND_REFERENCE_ID => 42], null, null, null, null];

        yield 'refundStatusWrongType' => [[OrderRefundTransformerInterface::KEY_REFUND_STATUS => 42], null, null, null, null];
    }

    private function buildTransformer(): OrderRefundTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new OrderRefundTransformer($amountTransformer);
    }
}
