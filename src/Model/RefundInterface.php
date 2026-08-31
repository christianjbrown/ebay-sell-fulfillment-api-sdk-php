<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface RefundInterface
{
    public function getRefundId(): ?string;

    public function getRefundStatus(): ?string;

    public function setRefundId(?string $value): self;

    public function setRefundStatus(?string $value): self;
}
