<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class SimpleAmount implements SimpleAmountInterface
{
    private ?string $currency = null;
    private ?string $value = null;

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setCurrency(?string $value): SimpleAmountInterface
    {
        $this->currency = $value;

        return $this;
    }

    public function setValue(?string $value): SimpleAmountInterface
    {
        $this->value = $value;

        return $this;
    }
}
