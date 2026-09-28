<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\Exception\Parse\ParseJsonExceptionInterface;
use ChristianBrown\ApiClient\Exception\Request\ConnectExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\TooManyRedirectsExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeResponseInterface;
use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\UpdateEvidencePaymentDisputeRequestInterface;
use ChristianBrown\OAuth2Client\Model\Exception\ExceptionInterface as OAuth2ExceptionInterface;
use Random\RandomException;

interface PaymentDisputeEvidenceApiInterface
{
    public const string API_PATH_ADD_EVIDENCE_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s/add_evidence';
    public const string API_PATH_FETCH_EVIDENCE_CONTENT_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s/fetch_evidence_content';
    public const string API_PATH_UPDATE_EVIDENCE_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s/update_evidence';
    public const string API_PATH_UPLOAD_EVIDENCE_FILE_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s/upload_evidence_file';

    /**
     * Kept for backward compatibility; the client now builds request URLs from
     * the injected {@see ApiHostInterface} and the `API_PATH_*` constants below.
     */
    public const string API_URL_ADD_EVIDENCE_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s/add_evidence';
    public const string API_URL_FETCH_EVIDENCE_CONTENT_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s/fetch_evidence_content';
    public const string API_URL_UPDATE_EVIDENCE_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s/update_evidence';
    public const string API_URL_UPLOAD_EVIDENCE_FILE_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s/upload_evidence_file';
    public const string CONTENT_TYPE_JPEG = 'image/jpeg';
    public const string CONTENT_TYPE_PNG = 'image/png';

    /**
     * eBay rejects the upload unless the multipart field is named `file`.
     */
    public const string FIELD_NAME_FILE = 'file';
    public const string KEY_EVIDENCE_ID = 'evidence_id';
    public const string KEY_FILE_ID = 'file_id';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Adds a new evidence set to a contested payment dispute, returning the id
     * of the evidence set that was created.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function addEvidence(string $paymentDisputeId, AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): AddEvidencePaymentDisputeResponseInterface;

    /**
     * Downloads one evidence file. The response is the raw file, not JSON, so
     * the bytes are returned as-is.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     */
    public function fetchEvidenceContent(string $paymentDisputeId, string $evidenceId, string $fileId): string;

    /**
     * Adds a file to, or removes a file from, an existing evidence set. eBay
     * answers `204 No Content`.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     */
    public function updateEvidence(string $paymentDisputeId, UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): void;

    /**
     * Uploads one evidence file as `multipart/form-data`, returning the id eBay
     * assigned to it. Only JPEG and PNG files are accepted.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws RandomException
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function uploadEvidenceFile(string $paymentDisputeId, string $fileName, string $contentType, string $contents): FileEvidenceInterface;
}
