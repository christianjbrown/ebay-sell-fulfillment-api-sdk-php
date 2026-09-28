<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PaymentDisputeOutcomeDetail implements PaymentDisputeOutcomeDetailInterface
{
    private ?SimpleAmountInterface $donationCreditAmount = null;
    private ?SimpleAmountInterface $fees = null;
    private ?SimpleAmountInterface $protectedAmount = null;
    private ?string $protectionStatus = null;
    private ?string $reasonForClosure = null;
    private ?SimpleAmountInterface $recoupAmount = null;
    private ?SimpleAmountInterface $totalFeeCredit = null;

    public function getDonationCreditAmount(): ?SimpleAmountInterface
    {
        return $this->donationCreditAmount;
    }

    public function getFees(): ?SimpleAmountInterface
    {
        return $this->fees;
    }

    public function getProtectedAmount(): ?SimpleAmountInterface
    {
        return $this->protectedAmount;
    }

    public function getProtectionStatus(): ?string
    {
        return $this->protectionStatus;
    }

    public function getReasonForClosure(): ?string
    {
        return $this->reasonForClosure;
    }

    public function getRecoupAmount(): ?SimpleAmountInterface
    {
        return $this->recoupAmount;
    }

    public function getTotalFeeCredit(): ?SimpleAmountInterface
    {
        return $this->totalFeeCredit;
    }

    public function setDonationCreditAmount(?SimpleAmountInterface $value): PaymentDisputeOutcomeDetailInterface
    {
        $this->donationCreditAmount = $value;

        return $this;
    }

    public function setFees(?SimpleAmountInterface $value): PaymentDisputeOutcomeDetailInterface
    {
        $this->fees = $value;

        return $this;
    }

    public function setProtectedAmount(?SimpleAmountInterface $value): PaymentDisputeOutcomeDetailInterface
    {
        $this->protectedAmount = $value;

        return $this;
    }

    public function setProtectionStatus(?string $value): PaymentDisputeOutcomeDetailInterface
    {
        $this->protectionStatus = $value;

        return $this;
    }

    public function setReasonForClosure(?string $value): PaymentDisputeOutcomeDetailInterface
    {
        $this->reasonForClosure = $value;

        return $this;
    }

    public function setRecoupAmount(?SimpleAmountInterface $value): PaymentDisputeOutcomeDetailInterface
    {
        $this->recoupAmount = $value;

        return $this;
    }

    public function setTotalFeeCredit(?SimpleAmountInterface $value): PaymentDisputeOutcomeDetailInterface
    {
        $this->totalFeeCredit = $value;

        return $this;
    }
}
