<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ShippingStep implements ShippingStepInterface
{
    private ?string $shippingCarrierCode = null;
    private ?string $shippingServiceCode = null;
    private ?ExtendedContactInterface $shipTo = null;
    private ?string $shipToReferenceId = null;

    public function getShippingCarrierCode(): ?string
    {
        return $this->shippingCarrierCode;
    }

    public function getShippingServiceCode(): ?string
    {
        return $this->shippingServiceCode;
    }

    public function getShipTo(): ?ExtendedContactInterface
    {
        return $this->shipTo;
    }

    public function getShipToReferenceId(): ?string
    {
        return $this->shipToReferenceId;
    }

    public function setShippingCarrierCode(?string $value): ShippingStepInterface
    {
        $this->shippingCarrierCode = $value;

        return $this;
    }

    public function setShippingServiceCode(?string $value): ShippingStepInterface
    {
        $this->shippingServiceCode = $value;

        return $this;
    }

    public function setShipTo(?ExtendedContactInterface $value): ShippingStepInterface
    {
        $this->shipTo = $value;

        return $this;
    }

    public function setShipToReferenceId(?string $value): ShippingStepInterface
    {
        $this->shipToReferenceId = $value;

        return $this;
    }
}
