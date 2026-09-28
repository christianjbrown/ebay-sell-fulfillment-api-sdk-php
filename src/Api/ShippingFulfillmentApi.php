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
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentDetailsInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentPagedCollectionInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ShippingFulfillmentDetailsSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentPagedCollectionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentTransformerInterface;

use function sprintf;

final class ShippingFulfillmentApi implements ShippingFulfillmentApiInterface
{
    private ApiHostInterface $apiHost;
    private ApiRequestSenderInterface $apiRequestSender;
    private ArrayToJsonTransformerInterface $arrayToJsonTransformer;

    /**
     * @var array<string, ShippingFulfillmentPagedCollectionInterface>
     */
    private array $collectionCache = [];
    private CredentialsInterface $credentials;

    /**
     * @var array<string, ShippingFulfillmentInterface>
     */
    private array $fulfillmentCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private ShippingFulfillmentDetailsSerializerInterface $shippingFulfillmentDetailsSerializer;
    private ShippingFulfillmentPagedCollectionTransformerInterface $shippingFulfillmentPagedCollectionTransformer;
    private ShippingFulfillmentTransformerInterface $shippingFulfillmentTransformer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ApiRequestSenderInterface $apiRequestSender, ArrayToJsonTransformerInterface $arrayToJsonTransformer, ShippingFulfillmentTransformerInterface $shippingFulfillmentTransformer, ShippingFulfillmentPagedCollectionTransformerInterface $shippingFulfillmentPagedCollectionTransformer, ShippingFulfillmentDetailsSerializerInterface $shippingFulfillmentDetailsSerializer, CredentialsInterface $credentials, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->apiRequestSender = $apiRequestSender;
        $this->arrayToJsonTransformer = $arrayToJsonTransformer;
        $this->shippingFulfillmentTransformer = $shippingFulfillmentTransformer;
        $this->shippingFulfillmentPagedCollectionTransformer = $shippingFulfillmentPagedCollectionTransformer;
        $this->shippingFulfillmentDetailsSerializer = $shippingFulfillmentDetailsSerializer;
        $this->credentials = $credentials;
        $this->apiHost = $apiHost;
    }

    public function createShippingFulfillment(string $orderId, ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): void
    {
        $url = $this->apiHost->getApiUrl().sprintf(self::API_PATH_SHIPPING_FULFILLMENTS_SPRINTF, $orderId);
        $context = new RequestContext(ApiRequestSenderInterface::METHOD_POST, $url);
        $body = $this->arrayToJsonTransformer->transform($this->shippingFulfillmentDetailsSerializer->serialize($shippingFulfillmentDetails), $context);

        // eBay answers 201 with an empty body, which is not decodable JSON, so
        // the raw sender is used rather than the JSON one.
        $this->apiRequestSender->post($url, [], $this->credentials->toHeaders(), $body);
    }

    public function getShippingFulfillment(string $orderId, string $fulfillmentId, bool $skipCache = false): ShippingFulfillmentInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $orderId, $fulfillmentId);
        if (!$skipCache) {
            if (isset($this->fulfillmentCache[$cacheKey])) {
                return $this->fulfillmentCache[$cacheKey];
            }
        }

        $url = $this->apiHost->getApiUrl().sprintf(self::API_PATH_SHIPPING_FULFILLMENT_SPRINTF, $orderId, $fulfillmentId);
        $data = $this->requestSender->get($url, [], $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $shippingFulfillment = $this->shippingFulfillmentTransformer->transform($data);
        $this->fulfillmentCache[$cacheKey] = $shippingFulfillment;

        return $shippingFulfillment;
    }

    public function getShippingFulfillments(string $orderId, bool $skipCache = false): ShippingFulfillmentPagedCollectionInterface
    {
        if (!$skipCache) {
            if (isset($this->collectionCache[$orderId])) {
                return $this->collectionCache[$orderId];
            }
        }

        $url = $this->apiHost->getApiUrl().sprintf(self::API_PATH_SHIPPING_FULFILLMENTS_SPRINTF, $orderId);
        $data = $this->requestSender->get($url, [], $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $collection = $this->shippingFulfillmentPagedCollectionTransformer->transform($data);
        $this->collectionCache[$orderId] = $collection;

        return $collection;
    }
}
