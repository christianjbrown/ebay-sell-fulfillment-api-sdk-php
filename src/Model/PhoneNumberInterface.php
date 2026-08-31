<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PhoneNumberInterface
{
    public function getPhoneNumber(): ?string;

    public function setPhoneNumber(?string $value): self;
}
