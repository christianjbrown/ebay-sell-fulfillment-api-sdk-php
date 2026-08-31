<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\RequestContextInterface;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApi;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApiInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\AcceptPaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ContestPaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\DisputeSummaryResponseInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityHistoryInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\AcceptPaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ContestPaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeSummaryResponseTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityHistoryTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentDisputeApi::class)]
final class PaymentDisputeApiTest extends TestCase
{
    private const string DISPUTE_ID = '5000005000';
    private const string HEADER_KEY = 'Authorization';
    private const string HEADER_VALUE = 'Bearer test-access-token';

    public function testAcceptPaymentDispute(): void
    {
        $request = self::createStub(AcceptPaymentDisputeRequestInterface::class);
        $url = sprintf(PaymentDisputeApiInterface::API_URL_ACCEPT_SPRINTF, self::DISPUTE_ID);

        $serializer = self::createMock(AcceptPaymentDisputeRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')->with($request)->willReturn(['revision' => 1]);

        $arrayToJsonTransformer = self::createMock(ArrayToJsonTransformerInterface::class);
        $arrayToJsonTransformer->expects(self::once())->method('transform')
            ->with(['revision' => 1], self::isInstanceOf(RequestContextInterface::class))
            ->willReturn('{"revision":1}');

        $apiRequestSender = self::createMock(ApiRequestSenderInterface::class);
        $apiRequestSender->expects(self::once())->method('post')
            ->with($url, [], self::headers(), '{"revision":1}')
            ->willReturn('');

        $api = self::buildWriteApi($apiRequestSender, $arrayToJsonTransformer, $serializer);

        $api->acceptPaymentDispute(self::DISPUTE_ID, $request);
    }

    public function testContestPaymentDispute(): void
    {
        $request = self::createStub(ContestPaymentDisputeRequestInterface::class);
        $url = sprintf(PaymentDisputeApiInterface::API_URL_CONTEST_SPRINTF, self::DISPUTE_ID);

        $serializer = self::createMock(ContestPaymentDisputeRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')->with($request)->willReturn(['revision' => 2]);

        $arrayToJsonTransformer = self::createMock(ArrayToJsonTransformerInterface::class);
        $arrayToJsonTransformer->expects(self::once())->method('transform')
            ->with(['revision' => 2], self::isInstanceOf(RequestContextInterface::class))
            ->willReturn('{"revision":2}');

        $apiRequestSender = self::createMock(ApiRequestSenderInterface::class);
        $apiRequestSender->expects(self::once())->method('post')
            ->with($url, [], self::headers(), '{"revision":2}')
            ->willReturn('');

        $api = self::buildWriteApi($apiRequestSender, $arrayToJsonTransformer, null, $serializer);

        $api->contestPaymentDispute(self::DISPUTE_ID, $request);
    }

    public function testGetActivitiesReturnsHistory(): void
    {
        $historyData = ['activity' => []];
        $history = self::createStub(PaymentDisputeActivityHistoryInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(PaymentDisputeApiInterface::API_URL_ACTIVITY_SPRINTF, self::DISPUTE_ID), [], self::headers())
            ->willReturn($historyData);

        $transformer = self::createMock(PaymentDisputeActivityHistoryTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with($historyData)->willReturn($history);

        $api = self::buildReadApi($requestSender, null, $transformer);

        self::assertSame($history, $api->getActivities(self::DISPUTE_ID));
    }

    public function testGetActivitiesSkipCacheRefetches(): void
    {
        $history = self::createStub(PaymentDisputeActivityHistoryInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['activity' => []]);

        $transformer = self::createStub(PaymentDisputeActivityHistoryTransformerInterface::class);
        $transformer->method('transform')->willReturn($history);

        $api = self::buildReadApi($requestSender, null, $transformer);

        self::assertSame($history, $api->getActivities(self::DISPUTE_ID, true));
        self::assertSame($history, $api->getActivities(self::DISPUTE_ID, true));
    }

    public function testGetActivitiesSkipCacheThrowsWhenResponseEmpty(): void
    {
        $api = self::buildReadApi(self::emptyRequestSender());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeApiInterface::UNEXPECTED_RESPONSE);

        $api->getActivities(self::DISPUTE_ID, true);
    }

    public function testGetActivitiesThrowsWhenResponseEmpty(): void
    {
        $api = self::buildReadApi(self::emptyRequestSender());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeApiInterface::UNEXPECTED_RESPONSE);

        $api->getActivities(self::DISPUTE_ID);
    }

    public function testGetActivitiesUsesCacheOnSecondCall(): void
    {
        $history = self::createStub(PaymentDisputeActivityHistoryInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['activity' => []]);

        $transformer = self::createStub(PaymentDisputeActivityHistoryTransformerInterface::class);
        $transformer->method('transform')->willReturn($history);

        $api = self::buildReadApi($requestSender, null, $transformer);

        self::assertSame($history, $api->getActivities(self::DISPUTE_ID));
        self::assertSame($history, $api->getActivities(self::DISPUTE_ID));
    }

    public function testGetPaymentDisputeReturnsDispute(): void
    {
        $disputeData = ['paymentDisputeId' => self::DISPUTE_ID];
        $dispute = self::createStub(PaymentDisputeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(PaymentDisputeApiInterface::API_URL_PAYMENT_DISPUTE_SPRINTF, self::DISPUTE_ID), [], self::headers())
            ->willReturn($disputeData);

        $transformer = self::createMock(PaymentDisputeTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with($disputeData)->willReturn($dispute);

        $api = self::buildReadApi($requestSender, $transformer);

        self::assertSame($dispute, $api->getPaymentDispute(self::DISPUTE_ID));
    }

    public function testGetPaymentDisputeSkipCacheRefetches(): void
    {
        $dispute = self::createStub(PaymentDisputeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['paymentDisputeId' => self::DISPUTE_ID]);

        $transformer = self::createStub(PaymentDisputeTransformerInterface::class);
        $transformer->method('transform')->willReturn($dispute);

        $api = self::buildReadApi($requestSender, $transformer);

        self::assertSame($dispute, $api->getPaymentDispute(self::DISPUTE_ID, true));
        self::assertSame($dispute, $api->getPaymentDispute(self::DISPUTE_ID, true));
    }

    public function testGetPaymentDisputeSkipCacheThrowsWhenResponseEmpty(): void
    {
        $api = self::buildReadApi(self::emptyRequestSender());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeApiInterface::UNEXPECTED_RESPONSE);

        $api->getPaymentDispute(self::DISPUTE_ID, true);
    }

    public function testGetPaymentDisputeSummariesReturnsSummaries(): void
    {
        $summaryData = ['total' => 1];
        $summaries = self::createStub(DisputeSummaryResponseInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PaymentDisputeApiInterface::API_URL_PAYMENT_DISPUTE_SUMMARY,
                [
                    PaymentDisputeApiInterface::KEY_LIMIT => '5',
                    PaymentDisputeApiInterface::KEY_OFFSET => '10',
                    PaymentDisputeApiInterface::KEY_ORDER_ID => '03-06614-05610',
                    PaymentDisputeApiInterface::KEY_BUYER_USERNAME => 'test-buyer',
                    PaymentDisputeApiInterface::KEY_OPEN_DATE_FROM => '2026-01-01T00:00:00.000Z',
                    PaymentDisputeApiInterface::KEY_OPEN_DATE_TO => '2026-02-01T00:00:00.000Z',
                    PaymentDisputeApiInterface::KEY_PAYMENT_DISPUTE_STATUS => PaymentDisputeApiInterface::PAYMENT_DISPUTE_STATUS_OPEN,
                ],
                self::headers(),
            )
            ->willReturn($summaryData);

        $transformer = self::createMock(DisputeSummaryResponseTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with($summaryData)->willReturn($summaries);

        $api = self::buildReadApi($requestSender, null, null, $transformer);

        $actual = $api->getPaymentDisputeSummaries(
            '03-06614-05610',
            'test-buyer',
            '2026-01-01T00:00:00.000Z',
            '2026-02-01T00:00:00.000Z',
            PaymentDisputeApiInterface::PAYMENT_DISPUTE_STATUS_OPEN,
            5,
            10,
        );

        self::assertSame($summaries, $actual);
    }

    public function testGetPaymentDisputeSummariesSkipCacheRefetches(): void
    {
        $summaries = self::createStub(DisputeSummaryResponseInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['total' => 1]);

        $transformer = self::createStub(DisputeSummaryResponseTransformerInterface::class);
        $transformer->method('transform')->willReturn($summaries);

        $api = self::buildReadApi($requestSender, null, null, $transformer);

        self::assertSame($summaries, $api->getPaymentDisputeSummaries(null, null, null, null, null, PaymentDisputeApiInterface::DEFAULT_LIMIT, 0, true));
        self::assertSame($summaries, $api->getPaymentDisputeSummaries(null, null, null, null, null, PaymentDisputeApiInterface::DEFAULT_LIMIT, 0, true));
    }

    public function testGetPaymentDisputeSummariesSkipCacheThrowsWhenResponseEmpty(): void
    {
        $api = self::buildReadApi(self::emptyRequestSender());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeApiInterface::UNEXPECTED_RESPONSE);

        $api->getPaymentDisputeSummaries(null, null, null, null, null, PaymentDisputeApiInterface::DEFAULT_LIMIT, 0, true);
    }

    public function testGetPaymentDisputeSummariesThrowsWhenResponseEmpty(): void
    {
        $api = self::buildReadApi(self::emptyRequestSender());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeApiInterface::UNEXPECTED_RESPONSE);

        $api->getPaymentDisputeSummaries();
    }

    public function testGetPaymentDisputeSummariesUsesCacheOnSecondCall(): void
    {
        $summaries = self::createStub(DisputeSummaryResponseInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PaymentDisputeApiInterface::API_URL_PAYMENT_DISPUTE_SUMMARY,
                [
                    PaymentDisputeApiInterface::KEY_LIMIT => (string) PaymentDisputeApiInterface::DEFAULT_LIMIT,
                    PaymentDisputeApiInterface::KEY_OFFSET => '0',
                ],
                self::headers(),
            )
            ->willReturn(['total' => 1]);

        $transformer = self::createStub(DisputeSummaryResponseTransformerInterface::class);
        $transformer->method('transform')->willReturn($summaries);

        $api = self::buildReadApi($requestSender, null, null, $transformer);

        self::assertSame($summaries, $api->getPaymentDisputeSummaries());
        self::assertSame($summaries, $api->getPaymentDisputeSummaries());
    }

    public function testGetPaymentDisputeThrowsWhenResponseEmpty(): void
    {
        $api = self::buildReadApi(self::emptyRequestSender());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeApiInterface::UNEXPECTED_RESPONSE);

        $api->getPaymentDispute(self::DISPUTE_ID);
    }

    public function testGetPaymentDisputeUsesCacheOnSecondCall(): void
    {
        $dispute = self::createStub(PaymentDisputeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['paymentDisputeId' => self::DISPUTE_ID]);

        $transformer = self::createStub(PaymentDisputeTransformerInterface::class);
        $transformer->method('transform')->willReturn($dispute);

        $api = self::buildReadApi($requestSender, $transformer);

        self::assertSame($dispute, $api->getPaymentDispute(self::DISPUTE_ID));
        self::assertSame($dispute, $api->getPaymentDispute(self::DISPUTE_ID));
    }

    private static function buildReadApi(?JsonApiRequestSenderInterface $requestSender = null, ?PaymentDisputeTransformerInterface $paymentDisputeTransformer = null, ?PaymentDisputeActivityHistoryTransformerInterface $activityHistoryTransformer = null, ?DisputeSummaryResponseTransformerInterface $summaryTransformer = null): PaymentDisputeApi
    {
        return new PaymentDisputeApi(
            $requestSender ?? self::createStub(JsonApiRequestSenderInterface::class),
            self::createStub(ApiRequestSenderInterface::class),
            self::createStub(ArrayToJsonTransformerInterface::class),
            $paymentDisputeTransformer ?? self::createStub(PaymentDisputeTransformerInterface::class),
            $activityHistoryTransformer ?? self::createStub(PaymentDisputeActivityHistoryTransformerInterface::class),
            $summaryTransformer ?? self::createStub(DisputeSummaryResponseTransformerInterface::class),
            self::createStub(AcceptPaymentDisputeRequestSerializerInterface::class),
            self::createStub(ContestPaymentDisputeRequestSerializerInterface::class),
            self::credentials(),
        );
    }

    private static function buildWriteApi(ApiRequestSenderInterface $apiRequestSender, ArrayToJsonTransformerInterface $arrayToJsonTransformer, ?AcceptPaymentDisputeRequestSerializerInterface $acceptSerializer = null, ?ContestPaymentDisputeRequestSerializerInterface $contestSerializer = null): PaymentDisputeApi
    {
        return new PaymentDisputeApi(
            self::createStub(JsonApiRequestSenderInterface::class),
            $apiRequestSender,
            $arrayToJsonTransformer,
            self::createStub(PaymentDisputeTransformerInterface::class),
            self::createStub(PaymentDisputeActivityHistoryTransformerInterface::class),
            self::createStub(DisputeSummaryResponseTransformerInterface::class),
            $acceptSerializer ?? self::createStub(AcceptPaymentDisputeRequestSerializerInterface::class),
            $contestSerializer ?? self::createStub(ContestPaymentDisputeRequestSerializerInterface::class),
            self::credentials(),
        );
    }

    private static function credentials(): CredentialsInterface
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        return $credentials;
    }

    private static function emptyRequestSender(): JsonApiRequestSenderInterface
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        return $requestSender;
    }

    /**
     * @return array<string, string>
     */
    private static function headers(): array
    {
        return [self::HEADER_KEY => self::HEADER_VALUE];
    }
}
