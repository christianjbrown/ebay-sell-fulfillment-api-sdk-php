<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\Payment;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentHoldInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Payment::class)]
#[CoversClass(PaymentTransformer::class)]
final class PaymentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $amountData = ['__amount__'];
        $paymentHoldsData = ['__paymentHolds__'];

        $amount = self::createStub(AmountInterface::class);
        $paymentHolds = [self::createStub(PaymentHoldInterface::class)];

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$amountData, $amount],
                ]
            );
        $paymentHoldsTransformer = self::createStub(PaymentHoldsTransformerInterface::class);
        $paymentHoldsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$paymentHoldsData, $paymentHolds],
                ]
            );

        $data = [
            PaymentTransformerInterface::KEY_AMOUNT => $amountData,
            PaymentTransformerInterface::KEY_PAYMENT_DATE => 'test-paymentDate',
            PaymentTransformerInterface::KEY_PAYMENT_HOLDS => $paymentHoldsData,
            PaymentTransformerInterface::KEY_PAYMENT_METHOD => 'test-paymentMethod',
            PaymentTransformerInterface::KEY_PAYMENT_REFERENCE_ID => 'test-paymentReferenceId',
            PaymentTransformerInterface::KEY_PAYMENT_STATUS => 'test-paymentStatus',
        ];

        $transformer = new PaymentTransformer($amountTransformer, $paymentHoldsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-paymentDate', $actual->getPaymentDate());
        self::assertSame($paymentHolds, $actual->getPaymentHolds());
        self::assertSame('test-paymentMethod', $actual->getPaymentMethod());
        self::assertSame('test-paymentReferenceId', $actual->getPaymentReferenceId());
        self::assertSame('test-paymentStatus', $actual->getPaymentStatus());
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

        yield 'nonArray' => [[PaymentTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPaymentHoldsNotSetCases')]
    public function testTransformPaymentHoldsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getPaymentHolds());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPaymentHoldsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentTransformerInterface::KEY_PAYMENT_HOLDS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedPaymentDate, ?string $expectedPaymentMethod, ?string $expectedPaymentReferenceId, ?string $expectedPaymentStatus): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedPaymentDate, $actual->getPaymentDate());
        self::assertSame($expectedPaymentMethod, $actual->getPaymentMethod());
        self::assertSame($expectedPaymentReferenceId, $actual->getPaymentReferenceId());
        self::assertSame($expectedPaymentStatus, $actual->getPaymentStatus());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'paymentDateWrongType' => [[PaymentTransformerInterface::KEY_PAYMENT_DATE => 42], null, null, null, null];

        yield 'paymentMethodWrongType' => [[PaymentTransformerInterface::KEY_PAYMENT_METHOD => 42], null, null, null, null];

        yield 'paymentReferenceIdWrongType' => [[PaymentTransformerInterface::KEY_PAYMENT_REFERENCE_ID => 42], null, null, null, null];

        yield 'paymentStatusWrongType' => [[PaymentTransformerInterface::KEY_PAYMENT_STATUS => 42], null, null, null, null];
    }

    private function buildTransformer(): PaymentTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $paymentHoldsTransformer = self::createStub(PaymentHoldsTransformerInterface::class);

        return new PaymentTransformer($amountTransformer, $paymentHoldsTransformer);
    }
}
