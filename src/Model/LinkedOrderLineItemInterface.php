<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface LinkedOrderLineItemInterface
{
    /**
     * @return array<int, NameValuePairInterface>
     */
    public function getLineItemAspects(): array;

    public function getLineItemId(): ?string;

    public function getMaxEstimatedDeliveryDate(): ?string;

    public function getMinEstimatedDeliveryDate(): ?string;

    public function getOrderId(): ?string;

    public function getSellerId(): ?string;

    /**
     * @return array<int, TrackingInfoInterface>
     */
    public function getShipments(): array;

    public function getTitle(): ?string;

    /**
     * @param array<int, NameValuePairInterface> $value
     */
    public function setLineItemAspects(array $value): self;

    public function setLineItemId(?string $value): self;

    public function setMaxEstimatedDeliveryDate(?string $value): self;

    public function setMinEstimatedDeliveryDate(?string $value): self;

    public function setOrderId(?string $value): self;

    public function setSellerId(?string $value): self;

    /**
     * @param array<int, TrackingInfoInterface> $value
     */
    public function setShipments(array $value): self;

    public function setTitle(?string $value): self;
}
