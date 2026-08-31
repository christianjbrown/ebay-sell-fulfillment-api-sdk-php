<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentSummaryInterface
{
    /**
     * @return array<int, PaymentInterface>
     */
    public function getPayments(): array;

    /**
     * @return array<int, OrderRefundInterface>
     */
    public function getRefunds(): array;

    public function getTotalDueSeller(): ?AmountInterface;

    /**
     * @param array<int, PaymentInterface> $value
     */
    public function setPayments(array $value): self;

    /**
     * @param array<int, OrderRefundInterface> $value
     */
    public function setRefunds(array $value): self;

    public function setTotalDueSeller(?AmountInterface $value): self;
}
