<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface DisputeAmountInterface
{
    public function getConvertedFromCurrency(): ?string;

    public function getConvertedFromValue(): ?string;

    public function getCurrency(): ?string;

    public function getExchangeRate(): ?string;

    public function getValue(): ?string;

    public function setConvertedFromCurrency(?string $value): self;

    public function setConvertedFromValue(?string $value): self;

    public function setCurrency(?string $value): self;

    public function setExchangeRate(?string $value): self;

    public function setValue(?string $value): self;
}
