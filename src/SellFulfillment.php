<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApiInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * The facade: exposes the resource clients from a ready-built container.
 * Build one through {@see SellFulfillmentFactoryInterface}.
 */
final class SellFulfillment implements SellFulfillmentInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
