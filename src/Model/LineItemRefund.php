<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class LineItemRefund implements LineItemRefundInterface
{
    private ?AmountInterface $amount = null;
    private ?string $refundDate = null;
    private ?string $refundId = null;
    private ?string $refundReferenceId = null;

    public function getAmount(): ?AmountInterface
    {
        return $this->amount;
    }

    public function getRefundDate(): ?string
    {
        return $this->refundDate;
    }

    public function getRefundId(): ?string
    {
        return $this->refundId;
    }

    public function getRefundReferenceId(): ?string
    {
        return $this->refundReferenceId;
    }

    public function setAmount(?AmountInterface $value): LineItemRefundInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setRefundDate(?string $value): LineItemRefundInterface
    {
        $this->refundDate = $value;

        return $this;
    }

    public function setRefundId(?string $value): LineItemRefundInterface
    {
        $this->refundId = $value;

        return $this;
    }

    public function setRefundReferenceId(?string $value): LineItemRefundInterface
    {
        $this->refundReferenceId = $value;

        return $this;
    }
}
