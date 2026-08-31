<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentDisputeOutcomeDetailInterface
{
    public function getFees(): ?SimpleAmountInterface;

    public function getProtectedAmount(): ?SimpleAmountInterface;

    public function getProtectionStatus(): ?string;

    public function getReasonForClosure(): ?string;

    public function getRecoupAmount(): ?SimpleAmountInterface;

    public function getTotalFeeCredit(): ?SimpleAmountInterface;

    public function setFees(?SimpleAmountInterface $value): self;

    public function setProtectedAmount(?SimpleAmountInterface $value): self;

    public function setProtectionStatus(?string $value): self;

    public function setReasonForClosure(?string $value): self;

    public function setRecoupAmount(?SimpleAmountInterface $value): self;

    public function setTotalFeeCredit(?SimpleAmountInterface $value): self;
}
