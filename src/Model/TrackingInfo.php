<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class TrackingInfo implements TrackingInfoInterface
{
    private ?string $shipmentTrackingNumber = null;
    private ?string $shippingCarrierCode = null;

    public function getShipmentTrackingNumber(): ?string
    {
        return $this->shipmentTrackingNumber;
    }

    public function getShippingCarrierCode(): ?string
    {
        return $this->shippingCarrierCode;
    }

    public function setShipmentTrackingNumber(?string $value): TrackingInfoInterface
    {
        $this->shipmentTrackingNumber = $value;

        return $this;
    }

    public function setShippingCarrierCode(?string $value): TrackingInfoInterface
    {
        $this->shippingCarrierCode = $value;

        return $this;
    }
}
