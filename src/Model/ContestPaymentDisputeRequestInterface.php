<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ContestPaymentDisputeRequestInterface
{
    public function getNote(): ?string;

    public function getReturnAddress(): ?ReturnAddressInterface;

    public function getRevision(): ?int;

    public function setNote(?string $value): self;

    public function setReturnAddress(?ReturnAddressInterface $value): self;

    public function setRevision(?int $value): self;
}
