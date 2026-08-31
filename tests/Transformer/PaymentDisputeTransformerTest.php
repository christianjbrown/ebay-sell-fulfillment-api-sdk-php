<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\InfoFromBuyerInterface;
use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransactionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDispute;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeOutcomeDetailInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddressInterface;
use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidencesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\InfoFromBuyerTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeOutcomeDetailTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ReturnAddressTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\SimpleAmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\StringsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentDispute::class)]
#[CoversClass(PaymentDisputeTransformer::class)]
final class PaymentDisputeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $amountData = ['__amount__'];
        $availableChoicesData = ['__availableChoices__'];
        $buyerProvidedData = ['__buyerProvided__'];
        $evidenceData = ['__evidence__'];
        $evidenceRequestsData = ['__evidenceRequests__'];
        $lineItemsData = ['__lineItems__'];
        $monetaryTransactionsData = ['__monetaryTransactions__'];
        $resolutionData = ['__resolution__'];
        $returnAddressData = ['__returnAddress__'];

        $amount = self::createStub(SimpleAmountInterface::class);
        $availableChoices = ['alpha', 'beta'];
        $buyerProvided = self::createStub(InfoFromBuyerInterface::class);
        $evidence = [self::createStub(DisputeEvidenceInterface::class)];
        $evidenceRequests = [self::createStub(EvidenceRequestInterface::class)];
        $lineItems = [self::createStub(OrderLineItemInterface::class)];
        $monetaryTransactions = [self::createStub(MonetaryTransactionInterface::class)];
        $resolution = self::createStub(PaymentDisputeOutcomeDetailInterface::class);
        $returnAddress = self::createStub(ReturnAddressInterface::class);

        $disputeEvidencesTransformer = self::createStub(DisputeEvidencesTransformerInterface::class);
        $disputeEvidencesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$evidenceData, $evidence],
                ]
            );
        $evidenceRequestsTransformer = self::createStub(EvidenceRequestsTransformerInterface::class);
        $evidenceRequestsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$evidenceRequestsData, $evidenceRequests],
                ]
            );
        $infoFromBuyerTransformer = self::createStub(InfoFromBuyerTransformerInterface::class);
        $infoFromBuyerTransformer->method('transform')
            ->willReturnMap(
                [
                    [$buyerProvidedData, $buyerProvided],
                ]
            );
        $monetaryTransactionsTransformer = self::createStub(MonetaryTransactionsTransformerInterface::class);
        $monetaryTransactionsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$monetaryTransactionsData, $monetaryTransactions],
                ]
            );
        $orderLineItemsTransformer = self::createStub(OrderLineItemsTransformerInterface::class);
        $orderLineItemsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$lineItemsData, $lineItems],
                ]
            );
        $paymentDisputeOutcomeDetailTransformer = self::createStub(PaymentDisputeOutcomeDetailTransformerInterface::class);
        $paymentDisputeOutcomeDetailTransformer->method('transform')
            ->willReturnMap(
                [
                    [$resolutionData, $resolution],
                ]
            );
        $returnAddressTransformer = self::createStub(ReturnAddressTransformerInterface::class);
        $returnAddressTransformer->method('transform')
            ->willReturnMap(
                [
                    [$returnAddressData, $returnAddress],
                ]
            );
        $simpleAmountTransformer = self::createStub(SimpleAmountTransformerInterface::class);
        $simpleAmountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$amountData, $amount],
                ]
            );
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$availableChoicesData, $availableChoices],
                ]
            );

        $data = [
            PaymentDisputeTransformerInterface::KEY_AMOUNT => $amountData,
            PaymentDisputeTransformerInterface::KEY_AVAILABLE_CHOICES => $availableChoicesData,
            PaymentDisputeTransformerInterface::KEY_BUYER_PROVIDED => $buyerProvidedData,
            PaymentDisputeTransformerInterface::KEY_BUYER_USERNAME => 'test-buyerUsername',
            PaymentDisputeTransformerInterface::KEY_CLOSED_DATE => 'test-closedDate',
            PaymentDisputeTransformerInterface::KEY_EVIDENCE => $evidenceData,
            PaymentDisputeTransformerInterface::KEY_EVIDENCE_REQUESTS => $evidenceRequestsData,
            PaymentDisputeTransformerInterface::KEY_LINE_ITEMS => $lineItemsData,
            PaymentDisputeTransformerInterface::KEY_MONETARY_TRANSACTIONS => $monetaryTransactionsData,
            PaymentDisputeTransformerInterface::KEY_NOTE => 'test-note',
            PaymentDisputeTransformerInterface::KEY_OPEN_DATE => 'test-openDate',
            PaymentDisputeTransformerInterface::KEY_ORDER_ID => 'test-orderId',
            PaymentDisputeTransformerInterface::KEY_PAYMENT_DISPUTE_ID => 'test-paymentDisputeId',
            PaymentDisputeTransformerInterface::KEY_PAYMENT_DISPUTE_STATUS => 'test-paymentDisputeStatus',
            PaymentDisputeTransformerInterface::KEY_REASON => 'test-reason',
            PaymentDisputeTransformerInterface::KEY_RESOLUTION => $resolutionData,
            PaymentDisputeTransformerInterface::KEY_RESPOND_BY_DATE => 'test-respondByDate',
            PaymentDisputeTransformerInterface::KEY_RETURN_ADDRESS => $returnAddressData,
            PaymentDisputeTransformerInterface::KEY_REVISION => 42,
            PaymentDisputeTransformerInterface::KEY_SELLER_RESPONSE => 'test-sellerResponse',
        ];

        $transformer = new PaymentDisputeTransformer($disputeEvidencesTransformer, $evidenceRequestsTransformer, $infoFromBuyerTransformer, $monetaryTransactionsTransformer, $orderLineItemsTransformer, $paymentDisputeOutcomeDetailTransformer, $returnAddressTransformer, $simpleAmountTransformer, $stringsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame($availableChoices, $actual->getAvailableChoices());
        self::assertSame($buyerProvided, $actual->getBuyerProvided());
        self::assertSame('test-buyerUsername', $actual->getBuyerUsername());
        self::assertSame('test-closedDate', $actual->getClosedDate());
        self::assertSame($evidence, $actual->getEvidence());
        self::assertSame($evidenceRequests, $actual->getEvidenceRequests());
        self::assertSame($lineItems, $actual->getLineItems());
        self::assertSame($monetaryTransactions, $actual->getMonetaryTransactions());
        self::assertSame('test-note', $actual->getNote());
        self::assertSame('test-openDate', $actual->getOpenDate());
        self::assertSame('test-orderId', $actual->getOrderId());
        self::assertSame('test-paymentDisputeId', $actual->getPaymentDisputeId());
        self::assertSame('test-paymentDisputeStatus', $actual->getPaymentDisputeStatus());
        self::assertSame('test-reason', $actual->getReason());
        self::assertSame($resolution, $actual->getResolution());
        self::assertSame('test-respondByDate', $actual->getRespondByDate());
        self::assertSame($returnAddress, $actual->getReturnAddress());
        self::assertSame(42, $actual->getRevision());
        self::assertSame('test-sellerResponse', $actual->getSellerResponse());
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

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformAvailableChoicesNotSetCases')]
    public function testTransformAvailableChoicesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getAvailableChoices());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformAvailableChoicesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_AVAILABLE_CHOICES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformBuyerProvidedNotSetCases')]
    public function testTransformBuyerProvidedNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getBuyerProvided());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformBuyerProvidedNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_BUYER_PROVIDED => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEvidenceNotSetCases')]
    public function testTransformEvidenceNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getEvidence());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEvidenceNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_EVIDENCE => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEvidenceRequestsNotSetCases')]
    public function testTransformEvidenceRequestsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getEvidenceRequests());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEvidenceRequestsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_EVIDENCE_REQUESTS => 'not-an-array']];
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

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_LINE_ITEMS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformMonetaryTransactionsNotSetCases')]
    public function testTransformMonetaryTransactionsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getMonetaryTransactions());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformMonetaryTransactionsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_MONETARY_TRANSACTIONS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformResolutionNotSetCases')]
    public function testTransformResolutionNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getResolution());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformResolutionNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_RESOLUTION => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformReturnAddressNotSetCases')]
    public function testTransformReturnAddressNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getReturnAddress());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformReturnAddressNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeTransformerInterface::KEY_RETURN_ADDRESS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedBuyerUsername, ?string $expectedClosedDate, ?string $expectedNote, ?string $expectedOpenDate, ?string $expectedOrderId, ?string $expectedPaymentDisputeId, ?string $expectedPaymentDisputeStatus, ?string $expectedReason, ?string $expectedRespondByDate, ?int $expectedRevision, ?string $expectedSellerResponse): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedBuyerUsername, $actual->getBuyerUsername());
        self::assertSame($expectedClosedDate, $actual->getClosedDate());
        self::assertSame($expectedNote, $actual->getNote());
        self::assertSame($expectedOpenDate, $actual->getOpenDate());
        self::assertSame($expectedOrderId, $actual->getOrderId());
        self::assertSame($expectedPaymentDisputeId, $actual->getPaymentDisputeId());
        self::assertSame($expectedPaymentDisputeStatus, $actual->getPaymentDisputeStatus());
        self::assertSame($expectedReason, $actual->getReason());
        self::assertSame($expectedRespondByDate, $actual->getRespondByDate());
        self::assertSame($expectedRevision, $actual->getRevision());
        self::assertSame($expectedSellerResponse, $actual->getSellerResponse());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?int, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null, null, null, null, null, null];

        yield 'buyerUsernameWrongType' => [[PaymentDisputeTransformerInterface::KEY_BUYER_USERNAME => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'closedDateWrongType' => [[PaymentDisputeTransformerInterface::KEY_CLOSED_DATE => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'noteWrongType' => [[PaymentDisputeTransformerInterface::KEY_NOTE => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'openDateWrongType' => [[PaymentDisputeTransformerInterface::KEY_OPEN_DATE => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'orderIdWrongType' => [[PaymentDisputeTransformerInterface::KEY_ORDER_ID => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'paymentDisputeIdWrongType' => [[PaymentDisputeTransformerInterface::KEY_PAYMENT_DISPUTE_ID => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'paymentDisputeStatusWrongType' => [[PaymentDisputeTransformerInterface::KEY_PAYMENT_DISPUTE_STATUS => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'reasonWrongType' => [[PaymentDisputeTransformerInterface::KEY_REASON => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'respondByDateWrongType' => [[PaymentDisputeTransformerInterface::KEY_RESPOND_BY_DATE => 42], null, null, null, null, null, null, null, null, null, null, null];

        yield 'revisionZero' => [[PaymentDisputeTransformerInterface::KEY_REVISION => 0], null, null, null, null, null, null, null, null, null, 0, null];

        yield 'revisionWrongType' => [[PaymentDisputeTransformerInterface::KEY_REVISION => 'not-int'], null, null, null, null, null, null, null, null, null, null, null];

        yield 'sellerResponseWrongType' => [[PaymentDisputeTransformerInterface::KEY_SELLER_RESPONSE => 42], null, null, null, null, null, null, null, null, null, null, null];
    }

    private function buildTransformer(): PaymentDisputeTransformer
    {
        $disputeEvidencesTransformer = self::createStub(DisputeEvidencesTransformerInterface::class);
        $evidenceRequestsTransformer = self::createStub(EvidenceRequestsTransformerInterface::class);
        $infoFromBuyerTransformer = self::createStub(InfoFromBuyerTransformerInterface::class);
        $monetaryTransactionsTransformer = self::createStub(MonetaryTransactionsTransformerInterface::class);
        $orderLineItemsTransformer = self::createStub(OrderLineItemsTransformerInterface::class);
        $paymentDisputeOutcomeDetailTransformer = self::createStub(PaymentDisputeOutcomeDetailTransformerInterface::class);
        $returnAddressTransformer = self::createStub(ReturnAddressTransformerInterface::class);
        $simpleAmountTransformer = self::createStub(SimpleAmountTransformerInterface::class);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);

        return new PaymentDisputeTransformer($disputeEvidencesTransformer, $evidenceRequestsTransformer, $infoFromBuyerTransformer, $monetaryTransactionsTransformer, $orderLineItemsTransformer, $paymentDisputeOutcomeDetailTransformer, $returnAddressTransformer, $simpleAmountTransformer, $stringsTransformer);
    }
}
