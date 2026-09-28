<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApiInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\PaymentDisputeEvidenceServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\PaymentDisputeServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\ShippingFulfillmentServiceRegistrar;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\Lock\LockInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * The composition root: builds the container from one registrar per resource
 * group (order, shipping fulfillment, payment dispute, payment dispute
 * evidence) plus core/auth, then exposes the resource clients through it.
 */
final class SellFulfillment implements SellFulfillmentInterface
{
    private ContainerInterface $container;

    public function __construct(string $clientId, string $clientSecret, string $marketplaceId, TtlAwareKeyValueStoreInterface $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, ?LockInterface $lock = null, ?ApiHostInterface $apiHost = null)
    {
        $resolvedApiHost = $apiHost ?? new ApiHost();
        $factory = new ContainerFactory();

        $this->container = $factory->build(
            [
                new CoreServiceRegistrar($clientId, $clientSecret, $marketplaceId, $accessTokenStore, $refreshTokenStore, $lock, $resolvedApiHost),
                new OrderServiceRegistrar($resolvedApiHost),
                new ShippingFulfillmentServiceRegistrar($resolvedApiHost),
                new PaymentDisputeServiceRegistrar($resolvedApiHost),
                new PaymentDisputeEvidenceServiceRegistrar($resolvedApiHost),
            ]
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getOrderApi(): OrderApiInterface
    {
        /**
         * @var OrderApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ORDER_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPaymentDisputeApi(): PaymentDisputeApiInterface
    {
        /**
         * @var PaymentDisputeApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_PAYMENT_DISPUTE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPaymentDisputeEvidenceApi(): PaymentDisputeEvidenceApiInterface
    {
        /**
         * @var PaymentDisputeEvidenceApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_PAYMENT_DISPUTE_EVIDENCE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getShippingFulfillmentApi(): ShippingFulfillmentApiInterface
    {
        /**
         * @var ShippingFulfillmentApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SHIPPING_FULFILLMENT_API);

        return $service;
    }
}
