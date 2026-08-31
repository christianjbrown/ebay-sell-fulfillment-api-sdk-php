<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderRefundInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentSummary;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentSummaryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentSummary::class)]
#[CoversClass(PaymentSummaryTransformer::class)]
final class PaymentSummaryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $paymentsData = ['__payments__'];
        $refundsData = ['__refunds__'];
        $totalDueSellerData = ['__totalDueSeller__'];

        $payments = [self::createStub(PaymentInterface::class)];
        $refunds = [self::createStub(OrderRefundInterface::class)];
        $totalDueSeller = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$totalDueSellerData, $totalDueSeller],
                ]
            );
        $orderRefundsTransformer = self::createStub(OrderRefundsTransformerInterface::class);
        $orderRefundsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$refundsData, $refunds],
                ]
            );
        $paymentsTransformer = self::createStub(PaymentsTransformerInterface::class);
        $paymentsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$paymentsData, $payments],
                ]
            );

        $data = [
            PaymentSummaryTransformerInterface::KEY_PAYMENTS => $paymentsData,
            PaymentSummaryTransformerInterface::KEY_REFUNDS => $refundsData,
            PaymentSummaryTransformerInterface::KEY_TOTAL_DUE_SELLER => $totalDueSellerData,
        ];

        $transformer = new PaymentSummaryTransformer($amountTransformer, $orderRefundsTransformer, $paymentsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($payments, $actual->getPayments());
        self::assertSame($refunds, $actual->getRefunds());
        self::assertSame($totalDueSeller, $actual->getTotalDueSeller());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPaymentsNotSetCases')]
    public function testTransformPaymentsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getPayments());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPaymentsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentSummaryTransformerInterface::KEY_PAYMENTS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformRefundsNotSetCases')]
    public function testTransformRefundsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getRefunds());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformRefundsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentSummaryTransformerInterface::KEY_REFUNDS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTotalDueSellerNotSetCases')]
    public function testTransformTotalDueSellerNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTotalDueSeller());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTotalDueSellerNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentSummaryTransformerInterface::KEY_TOTAL_DUE_SELLER => 'not-an-array']];
    }

    private function buildTransformer(): PaymentSummaryTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $orderRefundsTransformer = self::createStub(OrderRefundsTransformerInterface::class);
        $paymentsTransformer = self::createStub(PaymentsTransformerInterface::class);

        return new PaymentSummaryTransformer($amountTransformer, $orderRefundsTransformer, $paymentsTransformer);
    }
}
