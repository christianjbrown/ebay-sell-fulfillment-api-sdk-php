<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Charge implements ChargeInterface
{
    private ?AmountInterface $amount = null;
    private ?string $chargeType = null;

    public function getAmount(): ?AmountInterface
    {
        return $this->amount;
    }

    public function getChargeType(): ?string
    {
        return $this->chargeType;
    }

    public function setAmount(?AmountInterface $value): ChargeInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setChargeType(?string $value): ChargeInterface
    {
        $this->chargeType = $value;

        return $this;
    }
}
