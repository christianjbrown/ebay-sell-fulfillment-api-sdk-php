<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentInterface
{
    public function getAmount(): ?AmountInterface;

    public function getPaymentDate(): ?string;

    /**
     * @return array<int, PaymentHoldInterface>
     */
    public function getPaymentHolds(): array;

    public function getPaymentMethod(): ?string;

    public function getPaymentReferenceId(): ?string;

    public function getPaymentStatus(): ?string;

    public function setAmount(?AmountInterface $value): self;

    public function setPaymentDate(?string $value): self;

    /**
     * @param array<int, PaymentHoldInterface> $value
     */
    public function setPaymentHolds(array $value): self;

    public function setPaymentMethod(?string $value): self;

    public function setPaymentReferenceId(?string $value): self;

    public function setPaymentStatus(?string $value): self;
}
