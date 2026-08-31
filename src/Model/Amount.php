<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Amount implements AmountInterface
{
    private ?string $convertedFromCurrency = null;
    private ?string $convertedFromValue = null;
    private ?string $currency = null;
    private ?string $value = null;

    public function getConvertedFromCurrency(): ?string
    {
        return $this->convertedFromCurrency;
    }

    public function getConvertedFromValue(): ?string
    {
        return $this->convertedFromValue;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setConvertedFromCurrency(?string $value): AmountInterface
    {
        $this->convertedFromCurrency = $value;

        return $this;
    }

    public function setConvertedFromValue(?string $value): AmountInterface
    {
        $this->convertedFromValue = $value;

        return $this;
    }

    public function setCurrency(?string $value): AmountInterface
    {
        $this->currency = $value;

        return $this;
    }

    public function setValue(?string $value): AmountInterface
    {
        $this->value = $value;

        return $this;
    }
}
