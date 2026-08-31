<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface AcceptPaymentDisputeRequestInterface
{
    public function getReturnAddress(): ?ReturnAddressInterface;

    public function getRevision(): ?int;

    public function setReturnAddress(?ReturnAddressInterface $value): self;

    public function setRevision(?int $value): self;
}
