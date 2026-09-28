<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Api;

use ChristianBrown\ApiClient\Exception\Parse\ParseJsonExceptionInterface;
use ChristianBrown\ApiClient\Exception\Request\ConnectExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\TooManyRedirectsExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseExceptionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentDetailsInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentPagedCollectionInterface;
use ChristianBrown\OAuth2Client\Model\Exception\ExceptionInterface as OAuth2ExceptionInterface;

interface ShippingFulfillmentApiInterface
{
    public const string API_PATH_SHIPPING_FULFILLMENT_SPRINTF = '/sell/fulfillment/v1/order/%s/shipping_fulfillment/%s';
    public const string API_PATH_SHIPPING_FULFILLMENTS_SPRINTF = '/sell/fulfillment/v1/order/%s/shipping_fulfillment';

    /**
     * Kept for backward compatibility; the client now builds request URLs from
     * the injected {@see ApiHostInterface} and the `API_PATH_*` constants below.
     */
    public const string API_URL_SHIPPING_FULFILLMENT_SPRINTF = 'https://api.ebay.com/sell/fulfillment/v1/order/%s/shipping_fulfillment/%s';
    public const string API_URL_SHIPPING_FULFILLMENTS_SPRINTF = 'https://api.ebay.com/sell/fulfillment/v1/order/%s/shipping_fulfillment';
    public const string CACHE_KEY_SPRINTF = '%s:%s';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Marks one or more line items of an order as shipped. eBay answers `201
     * Created` with an empty body, carrying the new fulfillment id in the
     * `Location` response header, so nothing is returned here — read the
     * fulfillment back with `getShippingFulfillments()`.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     */
    public function createShippingFulfillment(string $orderId, ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): void;

    /**
     * Reads one shipping fulfillment (one shipment) of an order.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function getShippingFulfillment(string $orderId, string $fulfillmentId, bool $skipCache = false): ShippingFulfillmentInterface;

    /**
     * Reads every shipping fulfillment (shipment) of an order.
     *
     * @throws BadResponseExceptionInterface
     * @throws ConnectExceptionInterface
     * @throws OAuth2ExceptionInterface
     * @throws ParseJsonExceptionInterface
     * @throws TooManyRedirectsExceptionInterface
     * @throws UnexpectedResponseExceptionInterface
     */
    public function getShippingFulfillments(string $orderId, bool $skipCache = false): ShippingFulfillmentPagedCollectionInterface;
}
