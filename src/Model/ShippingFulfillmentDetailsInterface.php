<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ShippingFulfillmentDetailsInterface
{
    /**
     * @return array<int, LineItemReferenceInterface>
     */
    public function getLineItems(): array;

    public function getShippedDate(): ?string;

    public function getShippingCarrierCode(): ?string;

    public function getTrackingNumber(): ?string;

    /**
     * @param array<int, LineItemReferenceInterface> $value
     */
    public function setLineItems(array $value): self;

    public function setShippedDate(?string $value): self;

    public function setShippingCarrierCode(?string $value): self;

    public function setTrackingNumber(?string $value): self;
}
