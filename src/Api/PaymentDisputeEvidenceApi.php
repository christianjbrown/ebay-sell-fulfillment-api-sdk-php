<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\RequestContext;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformerInterface;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Http\MultipartFormDataBuilderInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeResponseInterface;
use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\UpdateEvidencePaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\AddEvidencePaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\UpdateEvidencePaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddEvidencePaymentDisputeResponseTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileEvidenceTransformerInterface;

use function sprintf;

final class PaymentDisputeEvidenceApi implements PaymentDisputeEvidenceApiInterface
{
    private AddEvidencePaymentDisputeRequestSerializerInterface $addEvidencePaymentDisputeRequestSerializer;
    private AddEvidencePaymentDisputeResponseTransformerInterface $addEvidencePaymentDisputeResponseTransformer;
    private ApiRequestSenderInterface $apiRequestSender;
    private ArrayToJsonTransformerInterface $arrayToJsonTransformer;
    private CredentialsInterface $credentials;
    private FileEvidenceTransformerInterface $fileEvidenceTransformer;
    private JsonToArrayTransformerInterface $jsonToArrayTransformer;
    private MultipartFormDataBuilderInterface $multipartFormDataBuilder;
    private JsonApiRequestSenderInterface $requestSender;
    private UpdateEvidencePaymentDisputeRequestSerializerInterface $updateEvidencePaymentDisputeRequestSerializer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ApiRequestSenderInterface $apiRequestSender, ArrayToJsonTransformerInterface $arrayToJsonTransformer, JsonToArrayTransformerInterface $jsonToArrayTransformer, MultipartFormDataBuilderInterface $multipartFormDataBuilder, AddEvidencePaymentDisputeResponseTransformerInterface $addEvidencePaymentDisputeResponseTransformer, FileEvidenceTransformerInterface $fileEvidenceTransformer, AddEvidencePaymentDisputeRequestSerializerInterface $addEvidencePaymentDisputeRequestSerializer, UpdateEvidencePaymentDisputeRequestSerializerInterface $updateEvidencePaymentDisputeRequestSerializer, CredentialsInterface $credentials)
    {
        $this->requestSender = $requestSender;
        $this->apiRequestSender = $apiRequestSender;
        $this->arrayToJsonTransformer = $arrayToJsonTransformer;
        $this->jsonToArrayTransformer = $jsonToArrayTransformer;
        $this->multipartFormDataBuilder = $multipartFormDataBuilder;
        $this->addEvidencePaymentDisputeResponseTransformer = $addEvidencePaymentDisputeResponseTransformer;
        $this->fileEvidenceTransformer = $fileEvidenceTransformer;
        $this->addEvidencePaymentDisputeRequestSerializer = $addEvidencePaymentDisputeRequestSerializer;
        $this->updateEvidencePaymentDisputeRequestSerializer = $updateEvidencePaymentDisputeRequestSerializer;
        $this->credentials = $credentials;
    }

    public function addEvidence(string $paymentDisputeId, AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): AddEvidencePaymentDisputeResponseInterface
    {
        $url = sprintf(self::API_URL_ADD_EVIDENCE_SPRINTF, $paymentDisputeId);
        $body = $this->addEvidencePaymentDisputeRequestSerializer->serialize($addEvidencePaymentDisputeRequest);
        $data = $this->requestSender->post($url, [], $this->credentials->toHeaders(), $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->addEvidencePaymentDisputeResponseTransformer->transform($data);
    }

    public function fetchEvidenceContent(string $paymentDisputeId, string $evidenceId, string $fileId): string
    {
        $url = sprintf(self::API_URL_FETCH_EVIDENCE_CONTENT_SPRINTF, $paymentDisputeId);
        $query = [
            self::KEY_EVIDENCE_ID => $evidenceId,
            self::KEY_FILE_ID => $fileId,
        ];

        // The response is an image, not JSON, so the raw sender is used.
        return $this->apiRequestSender->get($url, $query, $this->credentials->toHeaders());
    }

    public function updateEvidence(string $paymentDisputeId, UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): void
    {
        $url = sprintf(self::API_URL_UPDATE_EVIDENCE_SPRINTF, $paymentDisputeId);
        $context = new RequestContext(ApiRequestSenderInterface::METHOD_POST, $url);
        $body = $this->arrayToJsonTransformer->transform($this->updateEvidencePaymentDisputeRequestSerializer->serialize($updateEvidencePaymentDisputeRequest), $context);

        // eBay answers 204 with an empty body, which is not decodable JSON, so
        // the raw sender is used rather than the JSON one.
        $this->apiRequestSender->post($url, [], $this->credentials->toHeaders(), $body);
    }

    public function uploadEvidenceFile(string $paymentDisputeId, string $fileName, string $contentType, string $contents): FileEvidenceInterface
    {
        $url = sprintf(self::API_URL_UPLOAD_EVIDENCE_FILE_SPRINTF, $paymentDisputeId);
        $boundary = $this->multipartFormDataBuilder->generateBoundary();
        $body = $this->multipartFormDataBuilder->build($boundary, self::FIELD_NAME_FILE, $fileName, $contentType, $contents);

        $headers = $this->credentials->toHeaders();
        $headers[CredentialsInterface::HEADER_KEY_CONTENT_TYPE] = $this->multipartFormDataBuilder->toContentTypeHeaderValue($boundary);

        // The request is multipart rather than JSON, so the body is built here
        // and posted through the raw sender; the response is still JSON.
        $contentsResponse = $this->apiRequestSender->post($url, [], $headers, $body);
        $data = $this->jsonToArrayTransformer->transform($contentsResponse, new RequestContext(ApiRequestSenderInterface::METHOD_POST, $url));

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->fileEvidenceTransformer->transform($data);
    }
}
