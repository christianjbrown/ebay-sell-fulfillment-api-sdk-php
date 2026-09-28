<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\Exception\Parse\ParseJsonExceptionInterface;
use ChristianBrown\ApiClient\Exception\Request\ConnectExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\TooManyRedirectsExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AcceptPaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ContestPaymentDisputeRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\DisputeSummaryResponseInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityHistoryInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeInterface;
use ChristianBrown\OAuth2Client\Model\Exception\ExceptionInterface as OAuth2ExceptionInterface;

interface PaymentDisputeApiInterface
{
    public const string API_PATH_ACCEPT_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s/accept';
    public const string API_PATH_ACTIVITY_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s/activity';
    public const string API_PATH_CONTEST_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s/contest';
    public const string API_PATH_PAYMENT_DISPUTE_SPRINTF = '/sell/fulfillment/v1/payment_dispute/%s';
    public const string API_PATH_PAYMENT_DISPUTE_SUMMARY = '/sell/fulfillment/v1/payment_dispute_summary';

    /**
     * Kept for backward compatibility; the client now builds request URLs from
     * the injected {@see ApiHostInterface} and the `API_PATH_*` constants below.
     */
    public const string API_URL_ACCEPT_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s/accept';
    public const string API_URL_ACTIVITY_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s/activity';
    public const string API_URL_CONTEST_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s/contest';
    public const string API_URL_PAYMENT_DISPUTE_SPRINTF = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute/%s';
    public const string API_URL_PAYMENT_DISPUTE_SUMMARY = 'https://apiz.ebay.com/sell/fulfillment/v1/payment_dispute_summary';
    public const int DEFAULT_LIMIT = 200;
    public const string KEY_BUYER_USERNAME = 'buyer_username';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_OFFSET = 'offset';
    public const string KEY_OPEN_DATE_FROM = 'open_date_from';
    public const string KEY_OPEN_DATE_TO = 'open_date_to';
    public const string KEY_ORDER_ID = 'order_id';
    public const string KEY_PAYMENT_DISPUTE_STATUS = 'payment_dispute_status';

    /**
     * eBay's own ceiling on, and default for, `limit` on `getPaymentDisputeSummaries`.
     */
    public const int MAX_LIMIT = 200;
    public const string PAYMENT_DISPUTE_STATUS_ACTION_NEEDED = 'ACTION_NEEDED';
    public const string PAYMENT_DISPUTE_STATUS_CLOSED = 'CLOSED';
    public const string PAYMENT_DISPUTE_STATUS_OPEN = 'OPEN';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Accepts a payment dispute, agreeing to refund the buyer. eBay answers
     * `204 No Content`.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     */
    public function acceptPaymentDispute(string $paymentDisputeId, AcceptPaymentDisputeRequestInterface $acceptPaymentDisputeRequest): void;

    /**
     * Contests a payment dispute. eBay answers `204 No Content`.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     */
    public function contestPaymentDispute(string $paymentDisputeId, ContestPaymentDisputeRequestInterface $contestPaymentDisputeRequest): void;

    /**
     * Reads the activity history of a payment dispute.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function getActivities(string $paymentDisputeId, bool $skipCache = false): PaymentDisputeActivityHistoryInterface;

    /**
     * Reads one payment dispute in full.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function getPaymentDispute(string $paymentDisputeId, bool $skipCache = false): PaymentDisputeInterface;

    /**
     * Reads one page of payment dispute summaries. The two open-date bounds are
     * ISO-8601 UTC timestamps, for example `2026-01-01T00:00:00.000Z`.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function getPaymentDisputeSummaries(?string $orderId = null, ?string $buyerUsername = null, ?string $openDateFrom = null, ?string $openDateTo = null, ?string $paymentDisputeStatus = null, int $limit = self::DEFAULT_LIMIT, int $offset = 0, bool $skipCache = false): DisputeSummaryResponseInterface;
}
