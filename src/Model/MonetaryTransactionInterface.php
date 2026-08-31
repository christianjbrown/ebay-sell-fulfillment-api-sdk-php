<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface MonetaryTransactionInterface
{
    public function getAmount(): ?DisputeAmountInterface;

    public function getDate(): ?string;

    public function getReason(): ?string;

    public function getType(): ?string;

    public function setAmount(?DisputeAmountInterface $value): self;

    public function setDate(?string $value): self;

    public function setReason(?string $value): self;

    public function setType(?string $value): self;
}
