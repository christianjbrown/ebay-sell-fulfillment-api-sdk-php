<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ShippingStepInterface
{
    public function getShippingCarrierCode(): ?string;

    public function getShippingServiceCode(): ?string;

    public function getShipTo(): ?ExtendedContactInterface;

    public function getShipToReferenceId(): ?string;

    public function setShippingCarrierCode(?string $value): self;

    public function setShippingServiceCode(?string $value): self;

    public function setShipTo(?ExtendedContactInterface $value): self;

    public function setShipToReferenceId(?string $value): self;
}
