<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PhoneInterface
{
    public function getCountryCode(): ?string;

    public function getNumber(): ?string;

    public function setCountryCode(?string $value): self;

    public function setNumber(?string $value): self;
}
