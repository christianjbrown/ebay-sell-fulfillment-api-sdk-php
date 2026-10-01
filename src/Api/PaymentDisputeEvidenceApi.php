<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Multipart\MultipartPart;
use ChristianBrown\ApiClient\RequestContext;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
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
    private ApiHostInterface $apiHost;
    private ApiRequestSenderInterface $apiRequestSender;
    private ArrayToJsonTransformerInterface $arrayToJsonTransformer;
    private CredentialsInterface $credentials;
    private FileEvidenceTransformerInterface $fileEvidenceTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private UpdateEvidencePaymentDisputeRequestSerializerInterface $updateEvidencePaymentDisputeRequestSerializer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ApiRequestSenderInterface $apiRequestSender, ArrayToJsonTransformerInterface $arrayToJsonTransformer, AddEvidencePaymentDisputeResponseTransformerInterface $addEvidencePaymentDisputeResponseTransformer, FileEvidenceTransformerInterface $fileEvidenceTransformer, AddEvidencePaymentDisputeRequestSerializerInterface $addEvidencePaymentDisputeRequestSerializer, UpdateEvidencePaymentDisputeRequestSerializerInterface $updateEvidencePaymentDisputeRequestSerializer, CredentialsInterface $credentials, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->apiRequestSender = $apiRequestSender;
        $this->arrayToJsonTransformer = $arrayToJsonTransformer;
        $this->addEvidencePaymentDisputeResponseTransformer = $addEvidencePaymentDisputeResponseTransformer;
        $this->fileEvidenceTransformer = $fileEvidenceTransformer;
        $this->addEvidencePaymentDisputeRequestSerializer = $addEvidencePaymentDisputeRequestSerializer;
        $this->updateEvidencePaymentDisputeRequestSerializer = $updateEvidencePaymentDisputeRequestSerializer;
        $this->credentials = $credentials;
        $this->apiHost = $apiHost;
    }

    public function addEvidence(string $paymentDisputeId, AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): AddEvidencePaymentDisputeResponseInterface
    {
        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_ADD_EVIDENCE_SPRINTF, $paymentDisputeId);
        $body = $this->addEvidencePaymentDisputeRequestSerializer->serialize($addEvidencePaymentDisputeRequest);
        $data = $this->requestSender->post($url, [], $this->credentials->toHeaders(), $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->addEvidencePaymentDisputeResponseTransformer->transform($data);
    }

    public function fetchEvidenceContent(string $paymentDisputeId, string $evidenceId, string $fileId): string
    {
        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_FETCH_EVIDENCE_CONTENT_SPRINTF, $paymentDisputeId);
        $query = [
            self::KEY_EVIDENCE_ID => $evidenceId,
            self::KEY_FILE_ID => $fileId,
        ];

        // The response is an image, not JSON, so the raw sender is used.
        return $this->apiRequestSender->get($url, $query, $this->credentials->toHeaders());
    }

    public function updateEvidence(string $paymentDisputeId, UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): void
    {
        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_UPDATE_EVIDENCE_SPRINTF, $paymentDisputeId);
        $context = new RequestContext(ApiRequestSenderInterface::METHOD_POST, $url);
        $body = $this->arrayToJsonTransformer->transform($this->updateEvidencePaymentDisputeRequestSerializer->serialize($updateEvidencePaymentDisputeRequest), $context);

        // eBay answers 204 with an empty body, which is not decodable JSON, so
        // the raw sender is used rather than the JSON one.
        $this->apiRequestSender->post($url, [], $this->credentials->toHeaders(), $body);
    }

    public function uploadEvidenceFile(string $paymentDisputeId, string $fileName, string $contentType, string $contents): FileEvidenceInterface
    {
        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_UPLOAD_EVIDENCE_FILE_SPRINTF, $paymentDisputeId);
        // The one request eBay wants as multipart/form-data rather than JSON. api-client sets the
        // multipart Content-Type and boundary, replacing the JSON one in the credential headers.
        $file = new MultipartPart(self::FIELD_NAME_FILE, $contents, $fileName, [CredentialsInterface::HEADER_KEY_CONTENT_TYPE => $contentType]);
        $data = $this->requestSender->postMultipart($url, [], $this->credentials->toHeaders(), [$file]);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->fileEvidenceTransformer->transform($data);
    }
}
