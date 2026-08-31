<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class OrderRefund implements OrderRefundInterface
{
    private ?AmountInterface $amount = null;
    private ?string $refundDate = null;
    private ?string $refundId = null;
    private ?string $refundReferenceId = null;
    private ?string $refundStatus = null;

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

    public function getRefundStatus(): ?string
    {
        return $this->refundStatus;
    }

    public function setAmount(?AmountInterface $value): OrderRefundInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setRefundDate(?string $value): OrderRefundInterface
    {
        $this->refundDate = $value;

        return $this;
    }

    public function setRefundId(?string $value): OrderRefundInterface
    {
        $this->refundId = $value;

        return $this;
    }

    public function setRefundReferenceId(?string $value): OrderRefundInterface
    {
        $this->refundReferenceId = $value;

        return $this;
    }

    public function setRefundStatus(?string $value): OrderRefundInterface
    {
        $this->refundStatus = $value;

        return $this;
    }
}
