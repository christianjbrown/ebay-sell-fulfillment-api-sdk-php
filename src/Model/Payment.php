<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Payment implements PaymentInterface
{
    private ?AmountInterface $amount = null;
    private ?string $paymentDate = null;

    /**
     * @var array<int, PaymentHoldInterface>
     */
    private array $paymentHolds = [];
    private ?string $paymentMethod = null;
    private ?string $paymentReferenceId = null;
    private ?string $paymentStatus = null;

    public function getAmount(): ?AmountInterface
    {
        return $this->amount;
    }

    public function getPaymentDate(): ?string
    {
        return $this->paymentDate;
    }

    /**
     * @return array<int, PaymentHoldInterface>
     */
    public function getPaymentHolds(): array
    {
        return $this->paymentHolds;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function getPaymentReferenceId(): ?string
    {
        return $this->paymentReferenceId;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function setAmount(?AmountInterface $value): PaymentInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setPaymentDate(?string $value): PaymentInterface
    {
        $this->paymentDate = $value;

        return $this;
    }

    /**
     * @param array<int, PaymentHoldInterface> $value
     */
    public function setPaymentHolds(array $value): PaymentInterface
    {
        $this->paymentHolds = $value;

        return $this;
    }

    public function setPaymentMethod(?string $value): PaymentInterface
    {
        $this->paymentMethod = $value;

        return $this;
    }

    public function setPaymentReferenceId(?string $value): PaymentInterface
    {
        $this->paymentReferenceId = $value;

        return $this;
    }

    public function setPaymentStatus(?string $value): PaymentInterface
    {
        $this->paymentStatus = $value;

        return $this;
    }
}
