<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class DisputeAmount implements DisputeAmountInterface
{
    private ?string $convertedFromCurrency = null;
    private ?string $convertedFromValue = null;
    private ?string $currency = null;
    private ?string $exchangeRate = null;
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

    public function getExchangeRate(): ?string
    {
        return $this->exchangeRate;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setConvertedFromCurrency(?string $value): DisputeAmountInterface
    {
        $this->convertedFromCurrency = $value;

        return $this;
    }

    public function setConvertedFromValue(?string $value): DisputeAmountInterface
    {
        $this->convertedFromValue = $value;

        return $this;
    }

    public function setCurrency(?string $value): DisputeAmountInterface
    {
        $this->currency = $value;

        return $this;
    }

    public function setExchangeRate(?string $value): DisputeAmountInterface
    {
        $this->exchangeRate = $value;

        return $this;
    }

    public function setValue(?string $value): DisputeAmountInterface
    {
        $this->value = $value;

        return $this;
    }
}
