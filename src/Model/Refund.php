<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Refund implements RefundInterface
{
    private ?string $refundId = null;
    private ?string $refundStatus = null;

    public function getRefundId(): ?string
    {
        return $this->refundId;
    }

    public function getRefundStatus(): ?string
    {
        return $this->refundStatus;
    }

    public function setRefundId(?string $value): RefundInterface
    {
        $this->refundId = $value;

        return $this;
    }

    public function setRefundStatus(?string $value): RefundInterface
    {
        $this->refundStatus = $value;

        return $this;
    }
}
