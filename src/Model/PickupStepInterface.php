<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PickupStepInterface
{
    public function getMerchantLocationKey(): ?string;

    public function setMerchantLocationKey(?string $value): self;
}
