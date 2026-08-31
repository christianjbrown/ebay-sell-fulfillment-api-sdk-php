<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface TaxInterface
{
    public function getAmount(): ?AmountInterface;

    public function getTaxType(): ?string;

    public function setAmount(?AmountInterface $value): self;

    public function setTaxType(?string $value): self;
}
