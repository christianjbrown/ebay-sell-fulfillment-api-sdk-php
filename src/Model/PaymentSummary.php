<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PaymentSummary implements PaymentSummaryInterface
{
    /**
     * @var array<int, PaymentInterface>
     */
    private array $payments = [];

    /**
     * @var array<int, OrderRefundInterface>
     */
    private array $refunds = [];
    private ?AmountInterface $totalDueSeller = null;

    /**
     * @return array<int, PaymentInterface>
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @return array<int, OrderRefundInterface>
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }

    public function getTotalDueSeller(): ?AmountInterface
    {
        return $this->totalDueSeller;
    }

    /**
     * @param array<int, PaymentInterface> $value
     */
    public function setPayments(array $value): PaymentSummaryInterface
    {
        $this->payments = $value;

        return $this;
    }

    /**
     * @param array<int, OrderRefundInterface> $value
     */
    public function setRefunds(array $value): PaymentSummaryInterface
    {
        $this->refunds = $value;

        return $this;
    }

    public function setTotalDueSeller(?AmountInterface $value): PaymentSummaryInterface
    {
        $this->totalDueSeller = $value;

        return $this;
    }
}
