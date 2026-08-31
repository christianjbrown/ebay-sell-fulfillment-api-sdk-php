<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummary;
use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummaryTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\SimpleAmountTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentDisputeSummary::class)]
#[CoversClass(PaymentDisputeSummaryTransformer::class)]
final class PaymentDisputeSummaryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $amountData = ['__amount__'];

        $amount = self::createStub(SimpleAmountInterface::class);

        $simpleAmountTransformer = self::createStub(SimpleAmountTransformerInterface::class);
        $simpleAmountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$amountData, $amount],
                ]
            );

        $data = [
            PaymentDisputeSummaryTransformerInterface::KEY_AMOUNT => $amountData,
            PaymentDisputeSummaryTransformerInterface::KEY_BUYER_USERNAME => 'test-buyerUsername',
            PaymentDisputeSummaryTransformerInterface::KEY_CLOSED_DATE => 'test-closedDate',
            PaymentDisputeSummaryTransformerInterface::KEY_OPEN_DATE => 'test-openDate',
            PaymentDisputeSummaryTransformerInterface::KEY_ORDER_ID => 'test-orderId',
            PaymentDisputeSummaryTransformerInterface::KEY_PAYMENT_DISPUTE_ID => 'test-paymentDisputeId',
            PaymentDisputeSummaryTransformerInterface::KEY_PAYMENT_DISPUTE_STATUS => 'test-paymentDisputeStatus',
            PaymentDisputeSummaryTransformerInterface::KEY_REASON => 'test-reason',
            PaymentDisputeSummaryTransformerInterface::KEY_RESPOND_BY_DATE => 'test-respondByDate',
        ];

        $transformer = new PaymentDisputeSummaryTransformer($simpleAmountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-buyerUsername', $actual->getBuyerUsername());
        self::assertSame('test-closedDate', $actual->getClosedDate());
        self::assertSame('test-openDate', $actual->getOpenDate());
        self::assertSame('test-orderId', $actual->getOrderId());
        self::assertSame('test-paymentDisputeId', $actual->getPaymentDisputeId());
        self::assertSame('test-paymentDisputeStatus', $actual->getPaymentDisputeStatus());
        self::assertSame('test-reason', $actual->getReason());
        self::assertSame('test-respondByDate', $actual->getRespondByDate());
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

        yield 'nonArray' => [[PaymentDisputeSummaryTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedBuyerUsername, ?string $expectedClosedDate, ?string $expectedOpenDate, ?string $expectedOrderId, ?string $expectedPaymentDisputeId, ?string $expectedPaymentDisputeStatus, ?string $expectedReason, ?string $expectedRespondByDate): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedBuyerUsername, $actual->getBuyerUsername());
        self::assertSame($expectedClosedDate, $actual->getClosedDate());
        self::assertSame($expectedOpenDate, $actual->getOpenDate());
        self::assertSame($expectedOrderId, $actual->getOrderId());
        self::assertSame($expectedPaymentDisputeId, $actual->getPaymentDisputeId());
        self::assertSame($expectedPaymentDisputeStatus, $actual->getPaymentDisputeStatus());
        self::assertSame($expectedReason, $actual->getReason());
        self::assertSame($expectedRespondByDate, $actual->getRespondByDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null, null, null];

        yield 'buyerUsernameWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_BUYER_USERNAME => 42], null, null, null, null, null, null, null, null];

        yield 'closedDateWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_CLOSED_DATE => 42], null, null, null, null, null, null, null, null];

        yield 'openDateWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_OPEN_DATE => 42], null, null, null, null, null, null, null, null];

        yield 'orderIdWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_ORDER_ID => 42], null, null, null, null, null, null, null, null];

        yield 'paymentDisputeIdWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_PAYMENT_DISPUTE_ID => 42], null, null, null, null, null, null, null, null];

        yield 'paymentDisputeStatusWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_PAYMENT_DISPUTE_STATUS => 42], null, null, null, null, null, null, null, null];

        yield 'reasonWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_REASON => 42], null, null, null, null, null, null, null, null];

        yield 'respondByDateWrongType' => [[PaymentDisputeSummaryTransformerInterface::KEY_RESPOND_BY_DATE => 42], null, null, null, null, null, null, null, null];
    }

    private function buildTransformer(): PaymentDisputeSummaryTransformer
    {
        $simpleAmountTransformer = self::createStub(SimpleAmountTransformerInterface::class);

        return new PaymentDisputeSummaryTransformer($simpleAmountTransformer);
    }
}
