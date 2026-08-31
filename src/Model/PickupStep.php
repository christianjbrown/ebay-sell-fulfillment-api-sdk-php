<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PickupStep implements PickupStepInterface
{
    private ?string $merchantLocationKey = null;

    public function getMerchantLocationKey(): ?string
    {
        return $this->merchantLocationKey;
    }

    public function setMerchantLocationKey(?string $value): PickupStepInterface
    {
        $this->merchantLocationKey = $value;

        return $this;
    }
}
