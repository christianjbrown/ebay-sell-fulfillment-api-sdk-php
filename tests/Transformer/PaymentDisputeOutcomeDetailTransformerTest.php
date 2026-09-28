<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeOutcomeDetail;
use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeOutcomeDetailTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeOutcomeDetailTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\SimpleAmountTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentDisputeOutcomeDetail::class)]
#[CoversClass(PaymentDisputeOutcomeDetailTransformer::class)]
final class PaymentDisputeOutcomeDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $donationCreditAmountData = ['__donationCreditAmount__'];
        $feesData = ['__fees__'];
        $protectedAmountData = ['__protectedAmount__'];
        $recoupAmountData = ['__recoupAmount__'];
        $totalFeeCreditData = ['__totalFeeCredit__'];

        $donationCreditAmount = self::createStub(SimpleAmountInterface::class);
        $fees = self::createStub(SimpleAmountInterface::class);
        $protectedAmount = self::createStub(SimpleAmountInterface::class);
        $recoupAmount = self::createStub(SimpleAmountInterface::class);
        $totalFeeCredit = self::createStub(SimpleAmountInterface::class);

        $simpleAmountTransformer = self::createStub(SimpleAmountTransformerInterface::class);
        $simpleAmountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$donationCreditAmountData, $donationCreditAmount],
                    [$feesData, $fees],
                    [$protectedAmountData, $protectedAmount],
                    [$recoupAmountData, $recoupAmount],
                    [$totalFeeCreditData, $totalFeeCredit],
                ]
            );

        $data = [
            PaymentDisputeOutcomeDetailTransformerInterface::KEY_DONATION_CREDIT_AMOUNT => $donationCreditAmountData,
            PaymentDisputeOutcomeDetailTransformerInterface::KEY_FEES => $feesData,
            PaymentDisputeOutcomeDetailTransformerInterface::KEY_PROTECTED_AMOUNT => $protectedAmountData,
            PaymentDisputeOutcomeDetailTransformerInterface::KEY_PROTECTION_STATUS => 'test-protectionStatus',
            PaymentDisputeOutcomeDetailTransformerInterface::KEY_REASON_FOR_CLOSURE => 'test-reasonForClosure',
            PaymentDisputeOutcomeDetailTransformerInterface::KEY_RECOUP_AMOUNT => $recoupAmountData,
            PaymentDisputeOutcomeDetailTransformerInterface::KEY_TOTAL_FEE_CREDIT => $totalFeeCreditData,
        ];

        $transformer = new PaymentDisputeOutcomeDetailTransformer($simpleAmountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($donationCreditAmount, $actual->getDonationCreditAmount());
        self::assertSame($fees, $actual->getFees());
        self::assertSame($protectedAmount, $actual->getProtectedAmount());
        self::assertSame('test-protectionStatus', $actual->getProtectionStatus());
        self::assertSame('test-reasonForClosure', $actual->getReasonForClosure());
        self::assertSame($recoupAmount, $actual->getRecoupAmount());
        self::assertSame($totalFeeCredit, $actual->getTotalFeeCredit());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformDonationCreditAmountNotSetCases')]
    public function testTransformDonationCreditAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getDonationCreditAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformDonationCreditAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeOutcomeDetailTransformerInterface::KEY_DONATION_CREDIT_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFeesNotSetCases')]
    public function testTransformFeesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getFees());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFeesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeOutcomeDetailTransformerInterface::KEY_FEES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformProtectedAmountNotSetCases')]
    public function testTransformProtectedAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getProtectedAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformProtectedAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeOutcomeDetailTransformerInterface::KEY_PROTECTED_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformRecoupAmountNotSetCases')]
    public function testTransformRecoupAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getRecoupAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformRecoupAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeOutcomeDetailTransformerInterface::KEY_RECOUP_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedProtectionStatus, ?string $expectedReasonForClosure): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedProtectionStatus, $actual->getProtectionStatus());
        self::assertSame($expectedReasonForClosure, $actual->getReasonForClosure());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'protectionStatusWrongType' => [[PaymentDisputeOutcomeDetailTransformerInterface::KEY_PROTECTION_STATUS => 42], null, null];

        yield 'reasonForClosureWrongType' => [[PaymentDisputeOutcomeDetailTransformerInterface::KEY_REASON_FOR_CLOSURE => 42], null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTotalFeeCreditNotSetCases')]
    public function testTransformTotalFeeCreditNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTotalFeeCredit());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTotalFeeCreditNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeOutcomeDetailTransformerInterface::KEY_TOTAL_FEE_CREDIT => 'not-an-array']];
    }

    private function buildTransformer(): PaymentDisputeOutcomeDetailTransformer
    {
        $simpleAmountTransformer = self::createStub(SimpleAmountTransformerInterface::class);

        return new PaymentDisputeOutcomeDetailTransformer($simpleAmountTransformer);
    }
}
