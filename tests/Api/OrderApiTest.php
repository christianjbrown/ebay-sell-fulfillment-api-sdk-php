<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\SellFulfillment\Api\OrderApi;
use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\IssueRefundRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderSearchPagedCollectionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\RefundInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\IssueRefundRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderSearchPagedCollectionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\RefundTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrderApi::class)]
final class OrderApiTest extends TestCase
{
    private const string HEADER_KEY = 'Authorization';
    private const string HEADER_VALUE = 'Bearer test-access-token';
    private const string ORDER_ID = '03-06614-05610';

    public function testGetOrderReturnsOrder(): void
    {
        $orderData = ['orderId' => self::ORDER_ID];
        $order = self::createStub(OrderInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(OrderApiInterface::API_URL_ORDER_SPRINTF, self::ORDER_ID),
                [OrderApiInterface::KEY_FIELD_GROUPS => OrderApiInterface::FIELD_GROUPS_TAX_BREAKDOWN],
                self::headers(),
            )
            ->willReturn($orderData);

        $orderTransformer = self::createMock(OrderTransformerInterface::class);
        $orderTransformer->expects(self::once())->method('transform')
            ->with($orderData)
            ->willReturn($order);

        $api = self::buildApi($requestSender, $orderTransformer);

        self::assertSame($order, $api->getOrder(self::ORDER_ID, OrderApiInterface::FIELD_GROUPS_TAX_BREAKDOWN));
    }

    public function testGetOrderSkipCacheRefetches(): void
    {
        $order = self::createStub(OrderInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['orderId' => self::ORDER_ID]);

        $orderTransformer = self::createStub(OrderTransformerInterface::class);
        $orderTransformer->method('transform')->willReturn($order);

        $api = self::buildApi($requestSender, $orderTransformer);

        self::assertSame($order, $api->getOrder(self::ORDER_ID, null, true));
        self::assertSame($order, $api->getOrder(self::ORDER_ID, null, true));
    }

    public function testGetOrderSkipCacheThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(OrderApiInterface::UNEXPECTED_RESPONSE);

        $api->getOrder(self::ORDER_ID, null, true);
    }

    public function testGetOrdersReturnsCollection(): void
    {
        $collectionData = ['total' => 1];
        $collection = self::createStub(OrderSearchPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                OrderApiInterface::API_URL_ORDERS,
                [
                    OrderApiInterface::KEY_LIMIT => '10',
                    OrderApiInterface::KEY_OFFSET => '20',
                    OrderApiInterface::KEY_FILTER => 'creationdate:[2026-01-01T00:00:00.000Z..]',
                    OrderApiInterface::KEY_ORDER_IDS => self::ORDER_ID,
                    OrderApiInterface::KEY_FIELD_GROUPS => OrderApiInterface::FIELD_GROUPS_TAX_BREAKDOWN,
                ],
                self::headers(),
            )
            ->willReturn($collectionData);

        $collectionTransformer = self::createMock(OrderSearchPagedCollectionTransformerInterface::class);
        $collectionTransformer->expects(self::once())->method('transform')
            ->with($collectionData)
            ->willReturn($collection);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class), $collectionTransformer);

        $actual = $api->getOrders('creationdate:[2026-01-01T00:00:00.000Z..]', self::ORDER_ID, OrderApiInterface::FIELD_GROUPS_TAX_BREAKDOWN, 10, 20);

        self::assertSame($collection, $actual);
    }

    public function testGetOrdersSkipCacheRefetches(): void
    {
        $collection = self::createStub(OrderSearchPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['total' => 1]);

        $collectionTransformer = self::createStub(OrderSearchPagedCollectionTransformerInterface::class);
        $collectionTransformer->method('transform')->willReturn($collection);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class), $collectionTransformer);

        self::assertSame($collection, $api->getOrders(null, null, null, OrderApiInterface::DEFAULT_LIMIT, 0, true));
        self::assertSame($collection, $api->getOrders(null, null, null, OrderApiInterface::DEFAULT_LIMIT, 0, true));
    }

    public function testGetOrdersSkipCacheThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(OrderApiInterface::UNEXPECTED_RESPONSE);

        $api->getOrders(null, null, null, OrderApiInterface::DEFAULT_LIMIT, 0, true);
    }

    public function testGetOrdersThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(OrderApiInterface::UNEXPECTED_RESPONSE);

        $api->getOrders();
    }

    public function testGetOrdersUsesCacheOnSecondCall(): void
    {
        $collection = self::createStub(OrderSearchPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                OrderApiInterface::API_URL_ORDERS,
                [
                    OrderApiInterface::KEY_LIMIT => (string) OrderApiInterface::DEFAULT_LIMIT,
                    OrderApiInterface::KEY_OFFSET => '0',
                ],
                self::headers(),
            )
            ->willReturn(['total' => 1]);

        $collectionTransformer = self::createStub(OrderSearchPagedCollectionTransformerInterface::class);
        $collectionTransformer->method('transform')->willReturn($collection);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class), $collectionTransformer);

        self::assertSame($collection, $api->getOrders());
        self::assertSame($collection, $api->getOrders());
    }

    public function testGetOrderThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(OrderApiInterface::UNEXPECTED_RESPONSE);

        $api->getOrder(self::ORDER_ID);
    }

    public function testGetOrderUsesCacheOnSecondCall(): void
    {
        $order = self::createStub(OrderInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['orderId' => self::ORDER_ID]);

        $orderTransformer = self::createStub(OrderTransformerInterface::class);
        $orderTransformer->method('transform')->willReturn($order);

        $api = self::buildApi($requestSender, $orderTransformer);

        self::assertSame($order, $api->getOrder(self::ORDER_ID));
        self::assertSame($order, $api->getOrder(self::ORDER_ID));
    }

    public function testIssueRefundReturnsRefund(): void
    {
        $body = ['reasonForRefund' => 'BUYER_CANCEL'];
        $refundData = ['refundId' => 'test-refund-id'];
        $refund = self::createStub(RefundInterface::class);
        $request = self::createStub(IssueRefundRequestInterface::class);

        $serializer = self::createMock(IssueRefundRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')->with($request)->willReturn($body);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(OrderApiInterface::API_URL_ISSUE_REFUND_SPRINTF, self::ORDER_ID),
                [],
                self::headers(),
                $body,
            )
            ->willReturn($refundData);

        $refundTransformer = self::createMock(RefundTransformerInterface::class);
        $refundTransformer->expects(self::once())->method('transform')->with($refundData)->willReturn($refund);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class), null, $refundTransformer, $serializer);

        self::assertSame($refund, $api->issueRefund(self::ORDER_ID, $request));
    }

    public function testIssueRefundThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('post')->willReturn([]);

        $api = self::buildApi($requestSender, self::createStub(OrderTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(OrderApiInterface::UNEXPECTED_RESPONSE);

        $api->issueRefund(self::ORDER_ID, self::createStub(IssueRefundRequestInterface::class));
    }

    private static function buildApi(JsonApiRequestSenderInterface $requestSender, OrderTransformerInterface $orderTransformer, ?OrderSearchPagedCollectionTransformerInterface $collectionTransformer = null, ?RefundTransformerInterface $refundTransformer = null, ?IssueRefundRequestSerializerInterface $serializer = null): OrderApi
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        return new OrderApi(
            $requestSender,
            $orderTransformer,
            $collectionTransformer ?? self::createStub(OrderSearchPagedCollectionTransformerInterface::class),
            $refundTransformer ?? self::createStub(RefundTransformerInterface::class),
            $serializer ?? self::createStub(IssueRefundRequestSerializerInterface::class),
            $credentials,
        );
    }

    /**
     * @return array<string, string>
     */
    private static function headers(): array
    {
        return [self::HEADER_KEY => self::HEADER_VALUE];
    }
}
