<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\RequestContextInterface;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformerInterface;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApi;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\Http\MultipartFormDataBuilderInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeResponseInterface;
use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\UpdateEvidencePaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\AddEvidencePaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\UpdateEvidencePaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddEvidencePaymentDisputeResponseTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileEvidenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentDisputeEvidenceApi::class)]
final class PaymentDisputeEvidenceApiTest extends TestCase
{
    private const string DISPUTE_ID = '5000005000';
    private const string HEADER_KEY = 'Authorization';
    private const string HEADER_VALUE = 'Bearer test-access-token';

    public function testAddEvidenceReturnsResponse(): void
    {
        $body = ['evidenceType' => 'PROOF_OF_DELIVERY'];
        $responseData = ['evidenceId' => 'test-evidence-id'];
        $request = self::createStub(AddEvidencePaymentDisputeRequestInterface::class);
        $response = self::createStub(AddEvidencePaymentDisputeResponseInterface::class);

        $serializer = self::createMock(AddEvidencePaymentDisputeRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')->with($request)->willReturn($body);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(sprintf(PaymentDisputeEvidenceApiInterface::API_URL_ADD_EVIDENCE_SPRINTF, self::DISPUTE_ID), [], self::headers(), $body)
            ->willReturn($responseData);

        $transformer = self::createMock(AddEvidencePaymentDisputeResponseTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with($responseData)->willReturn($response);

        $api = self::buildJsonApi($requestSender, $transformer, $serializer);

        self::assertSame($response, $api->addEvidence(self::DISPUTE_ID, $request));
    }

    public function testAddEvidenceThrowsWhenResponseEmpty(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('post')->willReturn([]);

        $api = self::buildJsonApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeEvidenceApiInterface::UNEXPECTED_RESPONSE);

        $api->addEvidence(self::DISPUTE_ID, self::createStub(AddEvidencePaymentDisputeRequestInterface::class));
    }

    public function testFetchEvidenceContentReturnsRawBytes(): void
    {
        $apiRequestSender = self::createMock(ApiRequestSenderInterface::class);
        $apiRequestSender->expects(self::once())->method('get')
            ->with(
                sprintf(PaymentDisputeEvidenceApiInterface::API_URL_FETCH_EVIDENCE_CONTENT_SPRINTF, self::DISPUTE_ID),
                [
                    PaymentDisputeEvidenceApiInterface::KEY_EVIDENCE_ID => 'test-evidence-id',
                    PaymentDisputeEvidenceApiInterface::KEY_FILE_ID => 'test-file-id',
                ],
                self::headers(),
            )
            ->willReturn('binary-bytes');

        $api = self::buildEvidenceApi($apiRequestSender);

        self::assertSame('binary-bytes', $api->fetchEvidenceContent(self::DISPUTE_ID, 'test-evidence-id', 'test-file-id'));
    }

    public function testUpdateEvidence(): void
    {
        $request = self::createStub(UpdateEvidencePaymentDisputeRequestInterface::class);
        $url = sprintf(PaymentDisputeEvidenceApiInterface::API_URL_UPDATE_EVIDENCE_SPRINTF, self::DISPUTE_ID);

        $serializer = self::createMock(UpdateEvidencePaymentDisputeRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')->with($request)->willReturn(['evidenceId' => 'test-evidence-id']);

        $arrayToJsonTransformer = self::createMock(ArrayToJsonTransformerInterface::class);
        $arrayToJsonTransformer->expects(self::once())->method('transform')
            ->with(['evidenceId' => 'test-evidence-id'], self::isInstanceOf(RequestContextInterface::class))
            ->willReturn('{"evidenceId":"test-evidence-id"}');

        $apiRequestSender = self::createMock(ApiRequestSenderInterface::class);
        $apiRequestSender->expects(self::once())->method('post')
            ->with($url, [], self::headers(), '{"evidenceId":"test-evidence-id"}')
            ->willReturn('');

        $api = self::buildEvidenceApi($apiRequestSender, $arrayToJsonTransformer, null, null, null, $serializer);

        $api->updateEvidence(self::DISPUTE_ID, $request);
    }

    public function testUploadEvidenceFileReturnsFileEvidence(): void
    {
        $fileEvidence = self::createStub(FileEvidenceInterface::class);
        $url = sprintf(PaymentDisputeEvidenceApiInterface::API_URL_UPLOAD_EVIDENCE_FILE_SPRINTF, self::DISPUTE_ID);

        $multipartFormDataBuilder = self::createMock(MultipartFormDataBuilderInterface::class);
        $multipartFormDataBuilder->expects(self::once())->method('generateBoundary')->willReturn('test-boundary');
        $multipartFormDataBuilder->expects(self::once())->method('build')
            ->with('test-boundary', PaymentDisputeEvidenceApiInterface::FIELD_NAME_FILE, 'evidence.png', PaymentDisputeEvidenceApiInterface::CONTENT_TYPE_PNG, 'binary-bytes')
            ->willReturn('multipart-body');
        $multipartFormDataBuilder->expects(self::once())->method('toContentTypeHeaderValue')
            ->with('test-boundary')
            ->willReturn('multipart/form-data; boundary=test-boundary');

        $expectedHeaders = self::headers();
        $expectedHeaders[CredentialsInterface::HEADER_KEY_CONTENT_TYPE] = 'multipart/form-data; boundary=test-boundary';

        $apiRequestSender = self::createMock(ApiRequestSenderInterface::class);
        $apiRequestSender->expects(self::once())->method('post')
            ->with($url, [], $expectedHeaders, 'multipart-body')
            ->willReturn('{"fileId":"test-file-id"}');

        $jsonToArrayTransformer = self::createMock(JsonToArrayTransformerInterface::class);
        $jsonToArrayTransformer->expects(self::once())->method('transform')
            ->with('{"fileId":"test-file-id"}', self::isInstanceOf(RequestContextInterface::class))
            ->willReturn(['fileId' => 'test-file-id']);

        $fileEvidenceTransformer = self::createMock(FileEvidenceTransformerInterface::class);
        $fileEvidenceTransformer->expects(self::once())->method('transform')
            ->with(['fileId' => 'test-file-id'])
            ->willReturn($fileEvidence);

        $api = self::buildEvidenceApi($apiRequestSender, null, $jsonToArrayTransformer, $multipartFormDataBuilder, $fileEvidenceTransformer);

        self::assertSame($fileEvidence, $api->uploadEvidenceFile(self::DISPUTE_ID, 'evidence.png', PaymentDisputeEvidenceApiInterface::CONTENT_TYPE_PNG, 'binary-bytes'));
    }

    public function testUploadEvidenceFileThrowsWhenResponseEmpty(): void
    {
        $jsonToArrayTransformer = self::createStub(JsonToArrayTransformerInterface::class);
        $jsonToArrayTransformer->method('transform')->willReturn([]);

        $api = self::buildEvidenceApi(null, null, $jsonToArrayTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PaymentDisputeEvidenceApiInterface::UNEXPECTED_RESPONSE);

        $api->uploadEvidenceFile(self::DISPUTE_ID, 'evidence.png', PaymentDisputeEvidenceApiInterface::CONTENT_TYPE_PNG, 'binary-bytes');
    }

    private static function apiHost(): ApiHostInterface
    {
        $apiHost = self::createStub(ApiHostInterface::class);
        $apiHost->method('getApizUrl')->willReturn(ApiHostInterface::DEFAULT_APIZ_URL);

        return $apiHost;
    }

    private static function buildEvidenceApi(?ApiRequestSenderInterface $apiRequestSender = null, ?ArrayToJsonTransformerInterface $arrayToJsonTransformer = null, ?JsonToArrayTransformerInterface $jsonToArrayTransformer = null, ?MultipartFormDataBuilderInterface $multipartFormDataBuilder = null, ?FileEvidenceTransformerInterface $fileEvidenceTransformer = null, ?UpdateEvidencePaymentDisputeRequestSerializerInterface $updateEvidenceSerializer = null): PaymentDisputeEvidenceApi
    {
        return new PaymentDisputeEvidenceApi(
            self::createStub(JsonApiRequestSenderInterface::class),
            $apiRequestSender ?? self::createStub(ApiRequestSenderInterface::class),
            $arrayToJsonTransformer ?? self::createStub(ArrayToJsonTransformerInterface::class),
            $jsonToArrayTransformer ?? self::createStub(JsonToArrayTransformerInterface::class),
            $multipartFormDataBuilder ?? self::createStub(MultipartFormDataBuilderInterface::class),
            self::createStub(AddEvidencePaymentDisputeResponseTransformerInterface::class),
            $fileEvidenceTransformer ?? self::createStub(FileEvidenceTransformerInterface::class),
            self::createStub(AddEvidencePaymentDisputeRequestSerializerInterface::class),
            $updateEvidenceSerializer ?? self::createStub(UpdateEvidencePaymentDisputeRequestSerializerInterface::class),
            self::credentials(),
            self::apiHost(),
        );
    }

    private static function buildJsonApi(JsonApiRequestSenderInterface $requestSender, ?AddEvidencePaymentDisputeResponseTransformerInterface $addEvidenceTransformer = null, ?AddEvidencePaymentDisputeRequestSerializerInterface $addEvidenceSerializer = null): PaymentDisputeEvidenceApi
    {
        return new PaymentDisputeEvidenceApi(
            $requestSender,
            self::createStub(ApiRequestSenderInterface::class),
            self::createStub(ArrayToJsonTransformerInterface::class),
            self::createStub(JsonToArrayTransformerInterface::class),
            self::createStub(MultipartFormDataBuilderInterface::class),
            $addEvidenceTransformer ?? self::createStub(AddEvidencePaymentDisputeResponseTransformerInterface::class),
            self::createStub(FileEvidenceTransformerInterface::class),
            $addEvidenceSerializer ?? self::createStub(AddEvidencePaymentDisputeRequestSerializerInterface::class),
            self::createStub(UpdateEvidencePaymentDisputeRequestSerializerInterface::class),
            self::credentials(),
            self::apiHost(),
        );
    }

    private static function credentials(): CredentialsInterface
    {
        $credentials = self::createStub(CredentialsInterface::class);
        $credentials->method('toHeaders')->willReturn(self::headers());

        return $credentials;
    }

    /**
     * @return array<string, string>
     */
    private static function headers(): array
    {
        return [self::HEADER_KEY => self::HEADER_VALUE];
    }
}
