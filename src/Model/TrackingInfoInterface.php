<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface TrackingInfoInterface
{
    public function getShipmentTrackingNumber(): ?string;

    public function getShippingCarrierCode(): ?string;

    public function setShipmentTrackingNumber(?string $value): self;

    public function setShippingCarrierCode(?string $value): self;
}
