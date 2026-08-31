<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface AddressInterface
{
    public function getAddressLine1(): ?string;

    public function getAddressLine2(): ?string;

    public function getCity(): ?string;

    public function getCountryCode(): ?string;

    public function getCounty(): ?string;

    public function getPostalCode(): ?string;

    public function getStateOrProvince(): ?string;

    public function setAddressLine1(?string $value): self;

    public function setAddressLine2(?string $value): self;

    public function setCity(?string $value): self;

    public function setCountryCode(?string $value): self;

    public function setCounty(?string $value): self;

    public function setPostalCode(?string $value): self;

    public function setStateOrProvince(?string $value): self;
}
