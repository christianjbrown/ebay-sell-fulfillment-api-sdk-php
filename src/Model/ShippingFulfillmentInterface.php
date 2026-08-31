<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ShippingFulfillmentInterface
{
    public function getFulfillmentId(): ?string;

    /**
     * @return array<int, LineItemReferenceInterface>
     */
    public function getLineItems(): array;

    public function getShipmentTrackingNumber(): ?string;

    public function getShippedDate(): ?string;

    public function getShippingCarrierCode(): ?string;

    public function setFulfillmentId(?string $value): self;

    /**
     * @param array<int, LineItemReferenceInterface> $value
     */
    public function setLineItems(array $value): self;

    public function setShipmentTrackingNumber(?string $value): self;

    public function setShippedDate(?string $value): self;

    public function setShippingCarrierCode(?string $value): self;
}
