<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\Model\IssueRefundRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderSearchPagedCollectionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\RefundInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\IssueRefundRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderSearchPagedCollectionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\RefundTransformerInterface;

use function http_build_query;
use function sprintf;

final class OrderApi implements OrderApiInterface
{
    private ApiHostInterface $apiHost;
    private CredentialsInterface $credentials;
    private IssueRefundRequestSerializerInterface $issueRefundRequestSerializer;

    /**
     * @var array<string, OrderInterface>
     */
    private array $orderCache = [];

    /**
     * @var array<string, OrderSearchPagedCollectionInterface>
     */
    private array $orderSearchCache = [];
    private OrderSearchPagedCollectionTransformerInterface $orderSearchPagedCollectionTransformer;
    private OrderTransformerInterface $orderTransformer;
    private RefundTransformerInterface $refundTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, OrderTransformerInterface $orderTransformer, OrderSearchPagedCollectionTransformerInterface $orderSearchPagedCollectionTransformer, RefundTransformerInterface $refundTransformer, IssueRefundRequestSerializerInterface $issueRefundRequestSerializer, CredentialsInterface $credentials, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->orderTransformer = $orderTransformer;
        $this->orderSearchPagedCollectionTransformer = $orderSearchPagedCollectionTransformer;
        $this->refundTransformer = $refundTransformer;
        $this->issueRefundRequestSerializer = $issueRefundRequestSerializer;
        $this->credentials = $credentials;
        $this->apiHost = $apiHost;
    }

    public function getOrder(string $orderId, ?string $fieldGroups = null, bool $skipCache = false): OrderInterface
    {
        $query = self::applyFieldGroups([], $fieldGroups);
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $orderId, http_build_query($query));
        if (!$skipCache) {
            if (isset($this->orderCache[$cacheKey])) {
                return $this->orderCache[$cacheKey];
            }
        }

        $url = $this->apiHost->getApiUrl().sprintf(self::API_PATH_ORDER_SPRINTF, $orderId);
        $data = $this->requestSender->get($url, $query, $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $order = $this->orderTransformer->transform($data);
        $this->orderCache[$cacheKey] = $order;

        return $order;
    }

    public function getOrders(?string $filter = null, ?string $orderIds = null, ?string $fieldGroups = null, int $limit = self::DEFAULT_LIMIT, int $offset = 0, bool $skipCache = false): OrderSearchPagedCollectionInterface
    {
        $query = self::buildOrdersQuery($filter, $orderIds, $fieldGroups, $limit, $offset);
        $cacheKey = http_build_query($query);
        if (!$skipCache) {
            if (isset($this->orderSearchCache[$cacheKey])) {
                return $this->orderSearchCache[$cacheKey];
            }
        }

        $data = $this->requestSender->get($this->apiHost->getApiUrl().self::API_PATH_ORDERS, $query, $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $collection = $this->orderSearchPagedCollectionTransformer->transform($data);
        $this->orderSearchCache[$cacheKey] = $collection;

        return $collection;
    }

    public function issueRefund(string $orderId, IssueRefundRequestInterface $issueRefundRequest): RefundInterface
    {
        $url = $this->apiHost->getApiUrl().sprintf(self::API_PATH_ISSUE_REFUND_SPRINTF, $orderId);
        $body = $this->issueRefundRequestSerializer->serialize($issueRefundRequest);
        $data = $this->requestSender->post($url, [], $this->credentials->toHeaders(), $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->refundTransformer->transform($data);
    }

    /**
     * @phpstan-param array<string, string> $query
     *
     * @return array<string, string>
     */
    private static function applyFieldGroups(array $query, ?string $fieldGroups): array
    {
        if (null === $fieldGroups) {
            return $query;
        }
        $query[self::KEY_FIELD_GROUPS] = $fieldGroups;

        return $query;
    }

    /**
     * @phpstan-param array<string, string> $query
     *
     * @return array<string, string>
     */
    private static function applyFilter(array $query, ?string $filter): array
    {
        if (null === $filter) {
            return $query;
        }
        $query[self::KEY_FILTER] = $filter;

        return $query;
    }

    /**
     * @phpstan-param array<string, string> $query
     *
     * @return array<string, string>
     */
    private static function applyOrderIds(array $query, ?string $orderIds): array
    {
        if (null === $orderIds) {
            return $query;
        }
        $query[self::KEY_ORDER_IDS] = $orderIds;

        return $query;
    }

    /**
     * @return array<string, string>
     */
    private static function buildOrdersQuery(?string $filter, ?string $orderIds, ?string $fieldGroups, int $limit, int $offset): array
    {
        $query = [
            self::KEY_LIMIT => (string) $limit,
            self::KEY_OFFSET => (string) $offset,
        ];

        $query = self::applyFilter($query, $filter);
        $query = self::applyOrderIds($query, $orderIds);

        return self::applyFieldGroups($query, $fieldGroups);
    }
}
