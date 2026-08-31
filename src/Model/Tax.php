<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Tax implements TaxInterface
{
    private ?AmountInterface $amount = null;
    private ?string $taxType = null;

    public function getAmount(): ?AmountInterface
    {
        return $this->amount;
    }

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setAmount(?AmountInterface $value): TaxInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setTaxType(?string $value): TaxInterface
    {
        $this->taxType = $value;

        return $this;
    }
}
