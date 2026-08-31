<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface TaxAddressInterface
{
    public function getCity(): ?string;

    public function getCountryCode(): ?string;

    public function getPostalCode(): ?string;

    public function getStateOrProvince(): ?string;

    public function setCity(?string $value): self;

    public function setCountryCode(?string $value): self;

    public function setPostalCode(?string $value): self;

    public function setStateOrProvince(?string $value): self;
}
