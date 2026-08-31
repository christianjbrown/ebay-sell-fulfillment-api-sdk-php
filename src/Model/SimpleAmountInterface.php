<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface SimpleAmountInterface
{
    public function getCurrency(): ?string;

    public function getValue(): ?string;

    public function setCurrency(?string $value): self;

    public function setValue(?string $value): self;
}
