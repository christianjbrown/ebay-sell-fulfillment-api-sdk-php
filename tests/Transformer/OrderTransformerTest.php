<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\BuyerInterface;
use ChristianBrown\EBay\SellFulfillment\Model\CancelStatusInterface;
use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstructionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Model\Order;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentSummaryInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PricingSummaryInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ProgramInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\BuyerTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelStatusTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentSummaryTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PricingSummaryTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ProgramTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\StringsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Order::class)]
#[CoversClass(OrderTransformer::class)]
final class OrderTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $buyerData = ['__buyer__'];
        $cancelStatusData = ['__cancelStatus__'];
        $fulfillmentHrefsData = ['__fulfillmentHrefs__'];
        $fulfillmentStartInstructionsData = ['__fulfillmentStartInstructions__'];
        $lineItemsData = ['__lineItems__'];
        $paymentSummaryData = ['__paymentSummary__'];
        $pricingSummaryData = ['__pricingSummary__'];
        $programData = ['__program__'];
        $totalFeeBasisAmountData = ['__totalFeeBasisAmount__'];
        $totalMarketplaceFeeData = ['__totalMarketplaceFee__'];

        $buyer = self::createStub(BuyerInterface::class);
        $cancelStatus = self::createStub(CancelStatusInterface::class);
        $fulfillmentHrefs = ['alpha', 'beta'];
        $fulfillmentStartInstructions = [self::createStub(FulfillmentStartInstructionInterface::class)];
        $lineItems = [self::createStub(LineItemInterface::class)];
        $paymentSummary = self::createStub(PaymentSummaryInterface::class);
        $pricingSummary = self::createStub(PricingSummaryInterface::class);
        $program = self::createStub(ProgramInterface::class);
        $totalFeeBasisAmount = self::createStub(AmountInterface::class);
        $totalMarketplaceFee = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$totalFeeBasisAmountData, $totalFeeBasisAmount],
                    [$totalMarketplaceFeeData, $totalMarketplaceFee],
                ]
            );
        $buyerTransformer = self::createStub(BuyerTransformerInterface::class);
        $buyerTransformer->method('transform')
            ->willReturnMap(
                [
                    [$buyerData, $buyer],
                ]
            );
        $cancelStatusTransformer = self::createStub(CancelStatusTransformerInterface::class);
        $cancelStatusTransformer->method('transform')
            ->willReturnMap(
                [
                    [$cancelStatusData, $cancelStatus],
                ]
            );
        $fulfillmentStartInstructionsTransformer = self::createStub(FulfillmentStartInstructionsTransformerInterface::class);
        $fulfillmentStartInstructionsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$fulfillmentStartInstructionsData, $fulfillmentStartInstructions],
                ]
            );
        $lineItemsTransformer = self::createStub(LineItemsTransformerInterface::class);
        $lineItemsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$lineItemsData, $lineItems],
                ]
            );
        $paymentSummaryTransformer = self::createStub(PaymentSummaryTransformerInterface::class);
        $paymentSummaryTransformer->method('transform')
            ->willReturnMap(
                [
                    [$paymentSummaryData, $paymentSummary],
                ]
            );
        $pricingSummaryTransformer = self::createStub(PricingSummaryTransformerInterface::class);
        $pricingSummaryTransformer->method('transform')
            ->willReturnMap(
                [
                    [$pricingSummaryData, $pricingSummary],
                ]
            );
        $programTransformer = self::createStub(ProgramTransformerInterface::class);
        $programTransformer->method('transform')
            ->willReturnMap(
                [
                    [$programData, $program],
                ]
            );
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$fulfillmentHrefsData, $fulfillmentHrefs],
                ]
            );

        $data = [
            OrderTransformerInterface::KEY_BUYER => $buyerData,
            OrderTransformerInterface::KEY_BUYER_CHECKOUT_NOTES => 'test-buyerCheckoutNotes',
            OrderTransformerInterface::KEY_CANCEL_STATUS => $cancelStatusData,
            OrderTransformerInterface::KEY_CREATION_DATE => 'test-creationDate',
            OrderTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAX => true,
            OrderTransformerInterface::KEY_FULFILLMENT_HREFS => $fulfillmentHrefsData,
            OrderTransformerInterface::KEY_FULFILLMENT_START_INSTRUCTIONS => $fulfillmentStartInstructionsData,
            OrderTransformerInterface::KEY_LAST_MODIFIED_DATE => 'test-lastModifiedDate',
            OrderTransformerInterface::KEY_LEGACY_ORDER_ID => 'test-legacyOrderId',
            OrderTransformerInterface::KEY_LINE_ITEMS => $lineItemsData,
            OrderTransformerInterface::KEY_ORDER_FULFILLMENT_STATUS => 'test-orderFulfillmentStatus',
            OrderTransformerInterface::KEY_ORDER_ID => 'test-orderId',
            OrderTransformerInterface::KEY_ORDER_PAYMENT_STATUS => 'test-orderPaymentStatus',
            OrderTransformerInterface::KEY_PAYMENT_SUMMARY => $paymentSummaryData,
            OrderTransformerInterface::KEY_PRICING_SUMMARY => $pricingSummaryData,
            OrderTransformerInterface::KEY_PROGRAM => $programData,
            OrderTransformerInterface::KEY_SALES_RECORD_REFERENCE => 'test-salesRecordReference',
            OrderTransformerInterface::KEY_SELLER_ID => 'test-sellerId',
            OrderTransformerInterface::KEY_TOTAL_FEE_BASIS_AMOUNT => $totalFeeBasisAmountData,
            OrderTransformerInterface::KEY_TOTAL_MARKETPLACE_FEE => $totalMarketplaceFeeData,
        ];

        $transformer = new OrderTransformer($amountTransformer, $buyerTransformer, $cancelStatusTransformer, $fulfillmentStartInstructionsTransformer, $lineItemsTransformer, $paymentSummaryTransformer, $pricingSummaryTransformer, $programTransformer, $stringsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($buyer, $actual->getBuyer());
        self::assertSame('test-buyerCheckoutNotes', $actual->getBuyerCheckoutNotes());
        self::assertSame($cancelStatus, $actual->getCancelStatus());
        self::assertSame('test-creationDate', $actual->getCreationDate());
        self::assertTrue($actual->getEbayCollectAndRemitTax());
        self::assertSame($fulfillmentHrefs, $actual->getFulfillmentHrefs());
        self::assertSame($fulfillmentStartInstructions, $actual->getFulfillmentStartInstructions());
        self::assertSame('test-lastModifiedDate', $actual->getLastModifiedDate());
        self::assertSame('test-legacyOrderId', $actual->getLegacyOrderId());
        self::assertSame($lineItems, $actual->getLineItems());
        self::assertSame('test-orderFulfillmentStatus', $actual->getOrderFulfillmentStatus());
        self::assertSame('test-orderId', $actual->getOrderId());
        self::assertSame('test-orderPaymentStatus', $actual->getOrderPaymentStatus());
        self::assertSame($paymentSummary, $actual->getPaymentSummary());
        self::assertSame($pricingSummary, $actual->getPricingSummary());
        self::assertSame($program, $actual->getProgram());
        self::assertSame('test-salesRecordReference', $actual->getSalesRecordReference());
        self::assertSame('test-sellerId', $actual->getSellerId());
        self::assertSame($totalFeeBasisAmount, $actual->getTotalFeeBasisAmount());
        self::assertSame($totalMarketplaceFee, $actual->getTotalMarketplaceFee());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformBuyerNotSetCases')]
    public function testTransformBuyerNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getBuyer());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformBuyerNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_BUYER => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformCancelStatusNotSetCases')]
    public function testTransformCancelStatusNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getCancelStatus());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformCancelStatusNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_CANCEL_STATUS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFulfillmentHrefsNotSetCases')]
    public function testTransformFulfillmentHrefsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getFulfillmentHrefs());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFulfillmentHrefsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_FULFILLMENT_HREFS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFulfillmentStartInstructionsNotSetCases')]
    public function testTransformFulfillmentStartInstructionsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getFulfillmentStartInstructions());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFulfillmentStartInstructionsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_FULFILLMENT_START_INSTRUCTIONS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLineItemsNotSetCases')]
    public function testTransformLineItemsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getLineItems());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLineItemsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_LINE_ITEMS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPaymentSummaryNotSetCases')]
    public function testTransformPaymentSummaryNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getPaymentSummary());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPaymentSummaryNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_PAYMENT_SUMMARY => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPricingSummaryNotSetCases')]
    public function testTransformPricingSummaryNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getPricingSummary());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPricingSummaryNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_PRICING_SUMMARY => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformProgramNotSetCases')]
    public function testTransformProgramNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getProgram());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformProgramNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_PROGRAM => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedBuyerCheckoutNotes, ?string $expectedCreationDate, ?bool $expectedEbayCollectAndRemitTax, ?string $expectedLastModifiedDate, ?string $expectedLegacyOrderId, ?string $expectedOrderFulfillmentStatus, ?string $expectedOrderId, ?string $expectedOrderPaymentStatus, ?string $expectedSalesRecordReference, ?string $expectedSellerId): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedBuyerCheckoutNotes, $actual->getBuyerCheckoutNotes());
        self::assertSame($expectedCreationDate, $actual->getCreationDate());
        self::assertSame($expectedEbayCollectAndRemitTax, $actual->getEbayCollectAndRemitTax());
        self::assertSame($expectedLastModifiedDate, $actual->getLastModifiedDate());
        self::assertSame($expectedLegacyOrderId, $actual->getLegacyOrderId());
        self::assertSame($expectedOrderFulfillmentStatus, $actual->getOrderFulfillmentStatus());
        self::assertSame($expectedOrderId, $actual->getOrderId());
        self::assertSame($expectedOrderPaymentStatus, $actual->getOrderPaymentStatus());
        self::assertSame($expectedSalesRecordReference, $actual->getSalesRecordReference());
        self::assertSame($expectedSellerId, $actual->getSellerId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?bool, ?string, ?string, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null, null, null, null, null];

        yield 'buyerCheckoutNotesWrongType' => [[OrderTransformerInterface::KEY_BUYER_CHECKOUT_NOTES => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'creationDateWrongType' => [[OrderTransformerInterface::KEY_CREATION_DATE => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'ebayCollectAndRemitTaxFalse' => [[OrderTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAX => false], null, null, false, null, null, null, null, null, null, null];

        yield 'ebayCollectAndRemitTaxWrongType' => [[OrderTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAX => 'not-bool'], null, null, null, null, null, null, null, null, null, null];

        yield 'lastModifiedDateWrongType' => [[OrderTransformerInterface::KEY_LAST_MODIFIED_DATE => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'legacyOrderIdWrongType' => [[OrderTransformerInterface::KEY_LEGACY_ORDER_ID => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'orderFulfillmentStatusWrongType' => [[OrderTransformerInterface::KEY_ORDER_FULFILLMENT_STATUS => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'orderIdWrongType' => [[OrderTransformerInterface::KEY_ORDER_ID => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'orderPaymentStatusWrongType' => [[OrderTransformerInterface::KEY_ORDER_PAYMENT_STATUS => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'salesRecordReferenceWrongType' => [[OrderTransformerInterface::KEY_SALES_RECORD_REFERENCE => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'sellerIdWrongType' => [[OrderTransformerInterface::KEY_SELLER_ID => 42], null, null, null, null, null, null, null, null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTotalFeeBasisAmountNotSetCases')]
    public function testTransformTotalFeeBasisAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTotalFeeBasisAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTotalFeeBasisAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_TOTAL_FEE_BASIS_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTotalMarketplaceFeeNotSetCases')]
    public function testTransformTotalMarketplaceFeeNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTotalMarketplaceFee());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTotalMarketplaceFeeNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderTransformerInterface::KEY_TOTAL_MARKETPLACE_FEE => 'not-an-array']];
    }

    private function buildTransformer(): OrderTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $buyerTransformer = self::createStub(BuyerTransformerInterface::class);
        $cancelStatusTransformer = self::createStub(CancelStatusTransformerInterface::class);
        $fulfillmentStartInstructionsTransformer = self::createStub(FulfillmentStartInstructionsTransformerInterface::class);
        $lineItemsTransformer = self::createStub(LineItemsTransformerInterface::class);
        $paymentSummaryTransformer = self::createStub(PaymentSummaryTransformerInterface::class);
        $pricingSummaryTransformer = self::createStub(PricingSummaryTransformerInterface::class);
        $programTransformer = self::createStub(ProgramTransformerInterface::class);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);

        return new OrderTransformer($amountTransformer, $buyerTransformer, $cancelStatusTransformer, $fulfillmentStartInstructionsTransformer, $lineItemsTransformer, $paymentSummaryTransformer, $pricingSummaryTransformer, $programTransformer, $stringsTransformer);
    }
}
