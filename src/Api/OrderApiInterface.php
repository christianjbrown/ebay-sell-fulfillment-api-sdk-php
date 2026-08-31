<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\Exception\Parse\ParseJsonExceptionInterface;
use ChristianBrown\ApiClient\Exception\Request\ConnectExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\TooManyRedirectsExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\IssueRefundRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderSearchPagedCollectionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\RefundInterface;
use ChristianBrown\OAuth2Client\Model\Exception\ExceptionInterface as OAuth2ExceptionInterface;

interface OrderApiInterface extends ApiInterface
{
    public const string API_URL_ISSUE_REFUND_SPRINTF = 'https://api.ebay.com/sell/fulfillment/v1/order/%s/issue_refund';
    public const string API_URL_ORDER_SPRINTF = 'https://api.ebay.com/sell/fulfillment/v1/order/%s';
    public const string API_URL_ORDERS = 'https://api.ebay.com/sell/fulfillment/v1/order';
    public const string CACHE_KEY_SPRINTF = '%s:%s';
    public const int DEFAULT_LIMIT = 50;
    public const string FIELD_GROUPS_TAX_BREAKDOWN = 'TAX_BREAKDOWN';
    public const string KEY_FIELD_GROUPS = 'fieldGroups';
    public const string KEY_FILTER = 'filter';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_OFFSET = 'offset';
    public const string KEY_ORDER_IDS = 'orderIds';

    /**
     * eBay's own ceiling on `limit` for `getOrders`.
     */
    public const int MAX_LIMIT = 200;
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Reads a single order.
     *
     * @param string      $orderId     The unique eBay order id, for example `03-06614-05610`
     * @param null|string $fieldGroups `TAX_BREAKDOWN` to include the tax and fee breakdown
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function getOrder(string $orderId, ?string $fieldGroups = null, bool $skipCache = false): OrderInterface;

    /**
     * Reads one page of the seller's orders. eBay retains roughly two years of
     * order history, so a `creationdate` filter reaching back further than that
     * returns nothing extra. Drive the pages with the returned collection's
     * `getTotal()`, `getLimit()`, `getOffset()` and `getNext()`.
     *
     * @param null|string $filter      The `filter` query-string value, for example from `OrderFilterInterface::toFilterString()`
     * @param null|string $orderIds    A comma-separated list of order ids, used instead of `$filter`
     * @param null|string $fieldGroups `TAX_BREAKDOWN` to include the tax and fee breakdown
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function getOrders(?string $filter = null, ?string $orderIds = null, ?string $fieldGroups = null, int $limit = self::DEFAULT_LIMIT, int $offset = 0, bool $skipCache = false): OrderSearchPagedCollectionInterface;

    /**
     * Issues a refund against an order or against individual line items of it.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function issueRefund(string $orderId, IssueRefundRequestInterface $issueRefundRequest): RefundInterface;
}
