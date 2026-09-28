<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\RequestContext;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
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

use function http_build_query;
use function sprintf;

final class PaymentDisputeApi implements PaymentDisputeApiInterface
{
    private AcceptPaymentDisputeRequestSerializerInterface $acceptPaymentDisputeRequestSerializer;

    /**
     * @var array<string, PaymentDisputeActivityHistoryInterface>
     */
    private array $activityCache = [];
    private ApiHostInterface $apiHost;
    private ApiRequestSenderInterface $apiRequestSender;
    private ArrayToJsonTransformerInterface $arrayToJsonTransformer;
    private ContestPaymentDisputeRequestSerializerInterface $contestPaymentDisputeRequestSerializer;
    private CredentialsInterface $credentials;
    private DisputeSummaryResponseTransformerInterface $disputeSummaryResponseTransformer;
    private PaymentDisputeActivityHistoryTransformerInterface $paymentDisputeActivityHistoryTransformer;

    /**
     * @var array<string, PaymentDisputeInterface>
     */
    private array $paymentDisputeCache = [];
    private PaymentDisputeTransformerInterface $paymentDisputeTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    /**
     * @var array<string, DisputeSummaryResponseInterface>
     */
    private array $summaryCache = [];

    public function __construct(JsonApiRequestSenderInterface $requestSender, ApiRequestSenderInterface $apiRequestSender, ArrayToJsonTransformerInterface $arrayToJsonTransformer, PaymentDisputeTransformerInterface $paymentDisputeTransformer, PaymentDisputeActivityHistoryTransformerInterface $paymentDisputeActivityHistoryTransformer, DisputeSummaryResponseTransformerInterface $disputeSummaryResponseTransformer, AcceptPaymentDisputeRequestSerializerInterface $acceptPaymentDisputeRequestSerializer, ContestPaymentDisputeRequestSerializerInterface $contestPaymentDisputeRequestSerializer, CredentialsInterface $credentials, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->apiRequestSender = $apiRequestSender;
        $this->arrayToJsonTransformer = $arrayToJsonTransformer;
        $this->paymentDisputeTransformer = $paymentDisputeTransformer;
        $this->paymentDisputeActivityHistoryTransformer = $paymentDisputeActivityHistoryTransformer;
        $this->disputeSummaryResponseTransformer = $disputeSummaryResponseTransformer;
        $this->acceptPaymentDisputeRequestSerializer = $acceptPaymentDisputeRequestSerializer;
        $this->contestPaymentDisputeRequestSerializer = $contestPaymentDisputeRequestSerializer;
        $this->credentials = $credentials;
        $this->apiHost = $apiHost;
    }

    public function acceptPaymentDispute(string $paymentDisputeId, AcceptPaymentDisputeRequestInterface $acceptPaymentDisputeRequest): void
    {
        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_ACCEPT_SPRINTF, $paymentDisputeId);
        $context = new RequestContext(ApiRequestSenderInterface::METHOD_POST, $url);
        $body = $this->arrayToJsonTransformer->transform($this->acceptPaymentDisputeRequestSerializer->serialize($acceptPaymentDisputeRequest), $context);

        // eBay answers 204 with an empty body, which is not decodable JSON, so
        // the raw sender is used rather than the JSON one.
        $this->apiRequestSender->post($url, [], $this->credentials->toHeaders(), $body);
    }

    public function contestPaymentDispute(string $paymentDisputeId, ContestPaymentDisputeRequestInterface $contestPaymentDisputeRequest): void
    {
        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_CONTEST_SPRINTF, $paymentDisputeId);
        $context = new RequestContext(ApiRequestSenderInterface::METHOD_POST, $url);
        $body = $this->arrayToJsonTransformer->transform($this->contestPaymentDisputeRequestSerializer->serialize($contestPaymentDisputeRequest), $context);

        $this->apiRequestSender->post($url, [], $this->credentials->toHeaders(), $body);
    }

    public function getActivities(string $paymentDisputeId, bool $skipCache = false): PaymentDisputeActivityHistoryInterface
    {
        if (!$skipCache) {
            if (isset($this->activityCache[$paymentDisputeId])) {
                return $this->activityCache[$paymentDisputeId];
            }
        }

        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_ACTIVITY_SPRINTF, $paymentDisputeId);
        $data = $this->requestSender->get($url, [], $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $history = $this->paymentDisputeActivityHistoryTransformer->transform($data);
        $this->activityCache[$paymentDisputeId] = $history;

        return $history;
    }

    public function getPaymentDispute(string $paymentDisputeId, bool $skipCache = false): PaymentDisputeInterface
    {
        if (!$skipCache) {
            if (isset($this->paymentDisputeCache[$paymentDisputeId])) {
                return $this->paymentDisputeCache[$paymentDisputeId];
            }
        }

        $url = $this->apiHost->getApizUrl().sprintf(self::API_PATH_PAYMENT_DISPUTE_SPRINTF, $paymentDisputeId);
        $data = $this->requestSender->get($url, [], $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $paymentDispute = $this->paymentDisputeTransformer->transform($data);
        $this->paymentDisputeCache[$paymentDisputeId] = $paymentDispute;

        return $paymentDispute;
    }

    public function getPaymentDisputeSummaries(?string $orderId = null, ?string $buyerUsername = null, ?string $openDateFrom = null, ?string $openDateTo = null, ?string $paymentDisputeStatus = null, int $limit = self::DEFAULT_LIMIT, int $offset = 0, bool $skipCache = false): DisputeSummaryResponseInterface
    {
        $query = self::buildSummariesQuery($orderId, $buyerUsername, $openDateFrom, $openDateTo, $paymentDisputeStatus, $limit, $offset);
        $cacheKey = http_build_query($query);
        if (!$skipCache) {
            if (isset($this->summaryCache[$cacheKey])) {
                return $this->summaryCache[$cacheKey];
            }
        }

        $data = $this->requestSender->get($this->apiHost->getApizUrl().self::API_PATH_PAYMENT_DISPUTE_SUMMARY, $query, $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $summaries = $this->disputeSummaryResponseTransformer->transform($data);
        $this->summaryCache[$cacheKey] = $summaries;

        return $summaries;
    }

    /**
     * @phpstan-param array<string, string> $query
     *
     * @return array<string, string>
     */
    private static function applyOptional(array $query, string $key, ?string $value): array
    {
        if (null === $value) {
            return $query;
        }
        $query[$key] = $value;

        return $query;
    }

    /**
     * @return array<string, string>
     */
    private static function buildSummariesQuery(?string $orderId, ?string $buyerUsername, ?string $openDateFrom, ?string $openDateTo, ?string $paymentDisputeStatus, int $limit, int $offset): array
    {
        $query = [
            self::KEY_LIMIT => (string) $limit,
            self::KEY_OFFSET => (string) $offset,
        ];

        $query = self::applyOptional($query, self::KEY_ORDER_ID, $orderId);
        $query = self::applyOptional($query, self::KEY_BUYER_USERNAME, $buyerUsername);
        $query = self::applyOptional($query, self::KEY_OPEN_DATE_FROM, $openDateFrom);
        $query = self::applyOptional($query, self::KEY_OPEN_DATE_TO, $openDateTo);

        return self::applyOptional($query, self::KEY_PAYMENT_DISPUTE_STATUS, $paymentDisputeStatus);
    }
}
