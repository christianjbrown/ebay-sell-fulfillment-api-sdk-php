<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\RequestContextInterface;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApi;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApiInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentDetailsInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentPagedCollectionInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ShippingFulfillmentDetailsSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentPagedCollectionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ShippingFulfillmentApi::class)]
final class ShippingFulfillmentApiTest extends TestCase
{
    private const string FULFILLMENT_ID = '9405509699937986657803';
    private const string HEADER_KEY = 'Authorization';
    private const string HEADER_VALUE = 'Bearer test-access-token';
    private const string ORDER_ID = '03-06614-05610';

    public function testCreateShippingFulfillment(): void
    {
        $details = self::createStub(ShippingFulfillmentDetailsInterface::class);
        $url = sprintf(ShippingFulfillmentApiInterface::API_URL_SHIPPING_FULFILLMENTS_SPRINTF, self::ORDER_ID);

        $serializer = self::createMock(ShippingFulfillmentDetailsSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')->with($details)->willReturn(['trackingNumber' => 'test']);

        $arrayToJsonTransformer = self::createMock(ArrayToJsonTransformerInterface::class);
        $arrayToJsonTransformer->expects(self::once())->method('transform')
            ->with(['trackingNumber' => 'test'], self::isInstanceOf(RequestContextInterface::class))
            ->willReturn('{"trackingNumber":"test"}');

        $apiRequestSender = self::createMock(ApiRequestSenderInterface::class);
        $apiRequestSender->expects(self::once())->method('post')
            ->with($url, [], self::headers(), '{"trackingNumber":"test"}')
            ->willReturn('');

        $api = self::buildApi(self::createStub(JsonApiRequestSenderInterface::class), $apiRequestSender, $arrayToJsonTransformer, null, null, $serializer);

        $api->createShippingFulfillment(self::ORDER_ID, $details);
    }

    public function testGetShippingFulfillmentReturnsFulfillment(): void
    {
        $fulfillmentData = ['fulfillmentId' => self::FULFILLMENT_ID];
        $fulfillment = self::createStub(ShippingFulfillmentInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ShippingFulfillmentApiInterface::API_URL_SHIPPING_FULFILLMENT_SPRINTF, self::ORDER_ID, self::FULFILLMENT_ID),
                [],
                self::headers(),
            )
            ->willReturn($fulfillmentData);

        $transformer = self::createMock(ShippingFulfillmentTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with($fulfillmentData)->willReturn($fulfillment);

        $api = self::buildApi($requestSender, null, null, $transformer);

        self::assertSame($fulfillment, $api->getShippingFulfillment(self::ORDER_ID, self::FULFILLMENT_ID));
    }

    public function testGetShippingFulfillmentSkipCacheRefetches(): void
    {
        $fulfillment = self::createStub(ShippingFulfillmentInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['fulfillmentId' => self::FULFILLMENT_ID]);

        $transformer = self::createStub(ShippingFulfillmentTransformerInterface::class);
        $transformer->method('transform')->willReturn($fulfillment);

        $api = self::buildApi($requestSender, null, null, $transformer);

        $first = $api->getShippingFulfillment(self::ORDER_ID, self::FULFILLMENT_ID, true);
        $second = $api->getShippingFulfillment(self::ORDER_ID, self::FULFILLMENT_ID, true);

        self::assertSame($fulfillment, $first);
        self::assertSame($fulfillment, $second);
    }

    public function testGetShippingFulfillmentSkipCacheThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ShippingFulfillmentApiInterface::UNEXPECTED_RESPONSE);

        $api->getShippingFulfillment(self::ORDER_ID, self::FULFILLMENT_ID, true);
    }

    public function testGetShippingFulfillmentsReturnsCollection(): void
    {
        $collectionData = ['total' => 1];
        $collection = self::createStub(ShippingFulfillmentPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ShippingFulfillmentApiInterface::API_URL_SHIPPING_FULFILLMENTS_SPRINTF, self::ORDER_ID),
                [],
                self::headers(),
            )
            ->willReturn($collectionData);

        $collectionTransformer = self::createMock(ShippingFulfillmentPagedCollectionTransformerInterface::class);
        $collectionTransformer->expects(self::once())->method('transform')->with($collectionData)->willReturn($collection);

        $api = self::buildApi($requestSender, null, null, null, $collectionTransformer);

        self::assertSame($collection, $api->getShippingFulfillments(self::ORDER_ID));
    }

    public function testGetShippingFulfillmentsSkipCacheRefetches(): void
    {
        $collection = self::createStub(ShippingFulfillmentPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['total' => 1]);

        $collectionTransformer = self::createStub(ShippingFulfillmentPagedCollectionTransformerInterface::class);
        $collectionTransformer->method('transform')->willReturn($collection);

        $api = self::buildApi($requestSender, null, null, null, $collectionTransformer);

        $first = $api->getShippingFulfillments(self::ORDER_ID, true);
        $second = $api->getShippingFulfillments(self::ORDER_ID, true);

        self::assertSame($collection, $first);
        self::assertSame($collection, $second);
    }

    public function testGetShippingFulfillmentsSkipCacheThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ShippingFulfillmentApiInterface::UNEXPECTED_RESPONSE);

        $api->getShippingFulfillments(self::ORDER_ID, true);
    }

    public function testGetShippingFulfillmentsThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ShippingFulfillmentApiInterface::UNEXPECTED_RESPONSE);

        $api->getShippingFulfillments(self::ORDER_ID);
    }

    public function testGetShippingFulfillmentsUsesCacheOnSecondCall(): void
    {
        $collection = self::createStub(ShippingFulfillmentPagedCollectionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['total' => 1]);

        $collectionTransformer = self::createStub(ShippingFulfillmentPagedCollectionTransformerInterface::class);
        $collectionTransformer->method('transform')->willReturn($collection);

        $api = self::buildApi($requestSender, null, null, null, $collectionTransformer);

        $first = $api->getShippingFulfillments(self::ORDER_ID);
        $second = $api->getShippingFulfillments(self::ORDER_ID);

        self::assertSame($collection, $first);
        self::assertSame($collection, $second);
    }

    public function testGetShippingFulfillmentThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $api = self::buildApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ShippingFulfillmentApiInterface::UNEXPECTED_RESPONSE);

        $api->getShippingFulfillment(self::ORDER_ID, self::FULFILLMENT_ID);
    }

    public function testGetShippingFulfillmentUsesCacheOnSecondCall(): void
    {
        $fulfillment = self::createStub(ShippingFulfillmentInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['fulfillmentId' => self::FULFILLMENT_ID]);

        $transformer = self::createStub(ShippingFulfillmentTransformerInterface::class);
        $transformer->method('transform')->willReturn($fulfillment);

        $api = self::buildApi($requestSender, null, null, $transformer);

        $first = $api->getShippingFulfillment(self::ORDER_ID, self::FULFILLMENT_ID);
        $second = $api->getShippingFulfillment(self::ORDER_ID, self::FULFILLMENT_ID);

        self::assertSame($fulfillment, $first);
        self::assertSame($fulfillment, $second);
    }

    private static function buildApi(?JsonApiRequestSenderInterface $requestSender = null, ?ApiRequestSenderInterface $apiRequestSender = null, ?ArrayToJsonTransformerInterface $arrayToJsonTransformer = null, ?ShippingFulfillmentTransformerInterface $transformer = null, ?ShippingFulfillmentPagedCollectionTransformerInterface $collectionTransformer = null, ?ShippingFulfillmentDetailsSerializerInterface $serializer = null): ShippingFulfillmentApi
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        return new ShippingFulfillmentApi(
            $requestSender ?? self::createStub(JsonApiRequestSenderInterface::class),
            $apiRequestSender ?? self::createStub(ApiRequestSenderInterface::class),
            $arrayToJsonTransformer ?? self::createStub(ArrayToJsonTransformerInterface::class),
            $transformer ?? self::createStub(ShippingFulfillmentTransformerInterface::class),
            $collectionTransformer ?? self::createStub(ShippingFulfillmentPagedCollectionTransformerInterface::class),
            $serializer ?? self::createStub(ShippingFulfillmentDetailsSerializerInterface::class),
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
