<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class LinkedOrderLineItem implements LinkedOrderLineItemInterface
{
    /**
     * @var array<int, NameValuePairInterface>
     */
    private array $lineItemAspects = [];
    private ?string $lineItemId = null;
    private ?string $maxEstimatedDeliveryDate = null;
    private ?string $minEstimatedDeliveryDate = null;
    private ?string $orderId = null;
    private ?string $sellerId = null;

    /**
     * @var array<int, TrackingInfoInterface>
     */
    private array $shipments = [];
    private ?string $title = null;

    /**
     * @return array<int, NameValuePairInterface>
     */
    public function getLineItemAspects(): array
    {
        return $this->lineItemAspects;
    }

    public function getLineItemId(): ?string
    {
        return $this->lineItemId;
    }

    public function getMaxEstimatedDeliveryDate(): ?string
    {
        return $this->maxEstimatedDeliveryDate;
    }

    public function getMinEstimatedDeliveryDate(): ?string
    {
        return $this->minEstimatedDeliveryDate;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getSellerId(): ?string
    {
        return $this->sellerId;
    }

    /**
     * @return array<int, TrackingInfoInterface>
     */
    public function getShipments(): array
    {
        return $this->shipments;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param array<int, NameValuePairInterface> $value
     */
    public function setLineItemAspects(array $value): LinkedOrderLineItemInterface
    {
        $this->lineItemAspects = $value;

        return $this;
    }

    public function setLineItemId(?string $value): LinkedOrderLineItemInterface
    {
        $this->lineItemId = $value;

        return $this;
    }

    public function setMaxEstimatedDeliveryDate(?string $value): LinkedOrderLineItemInterface
    {
        $this->maxEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setMinEstimatedDeliveryDate(?string $value): LinkedOrderLineItemInterface
    {
        $this->minEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setOrderId(?string $value): LinkedOrderLineItemInterface
    {
        $this->orderId = $value;

        return $this;
    }

    public function setSellerId(?string $value): LinkedOrderLineItemInterface
    {
        $this->sellerId = $value;

        return $this;
    }

    /**
     * @param array<int, TrackingInfoInterface> $value
     */
    public function setShipments(array $value): LinkedOrderLineItemInterface
    {
        $this->shipments = $value;

        return $this;
    }

    public function setTitle(?string $value): LinkedOrderLineItemInterface
    {
        $this->title = $value;

        return $this;
    }
}
