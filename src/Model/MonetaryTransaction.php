<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class MonetaryTransaction implements MonetaryTransactionInterface
{
    private ?DisputeAmountInterface $amount = null;
    private ?string $date = null;
    private ?string $reason = null;
    private ?string $type = null;

    public function getAmount(): ?DisputeAmountInterface
    {
        return $this->amount;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setAmount(?DisputeAmountInterface $value): MonetaryTransactionInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setDate(?string $value): MonetaryTransactionInterface
    {
        $this->date = $value;

        return $this;
    }

    public function setReason(?string $value): MonetaryTransactionInterface
    {
        $this->reason = $value;

        return $this;
    }

    public function setType(?string $value): MonetaryTransactionInterface
    {
        $this->type = $value;

        return $this;
    }
}
