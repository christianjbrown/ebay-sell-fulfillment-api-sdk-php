<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface LineItemRefundInterface
{
    public function getAmount(): ?AmountInterface;

    public function getRefundDate(): ?string;

    public function getRefundId(): ?string;

    public function getRefundReferenceId(): ?string;

    public function setAmount(?AmountInterface $value): self;

    public function setRefundDate(?string $value): self;

    public function setRefundId(?string $value): self;

    public function setRefundReferenceId(?string $value): self;
}
