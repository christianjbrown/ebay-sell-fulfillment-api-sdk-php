<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ItemLocationInterface
{
    public function getCountryCode(): ?string;

    public function getLocation(): ?string;

    public function getPostalCode(): ?string;

    public function setCountryCode(?string $value): self;

    public function setLocation(?string $value): self;

    public function setPostalCode(?string $value): self;
}
