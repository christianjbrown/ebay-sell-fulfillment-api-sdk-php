<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ChargeInterface
{
    public function getAmount(): ?AmountInterface;

    public function getChargeType(): ?string;

    public function setAmount(?AmountInterface $value): self;

    public function setChargeType(?string $value): self;
}
