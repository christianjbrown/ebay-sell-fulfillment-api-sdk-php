<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PaymentDisputeSummary implements PaymentDisputeSummaryInterface
{
    private ?SimpleAmountInterface $amount = null;
    private ?string $buyerUsername = null;
    private ?string $closedDate = null;
    private ?string $openDate = null;
    private ?string $orderId = null;
    private ?string $paymentDisputeId = null;
    private ?string $paymentDisputeStatus = null;
    private ?string $reason = null;
    private ?string $respondByDate = null;

    public function getAmount(): ?SimpleAmountInterface
    {
        return $this->amount;
    }

    public function getBuyerUsername(): ?string
    {
        return $this->buyerUsername;
    }

    public function getClosedDate(): ?string
    {
        return $this->closedDate;
    }

    public function getOpenDate(): ?string
    {
        return $this->openDate;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getPaymentDisputeId(): ?string
    {
        return $this->paymentDisputeId;
    }

    public function getPaymentDisputeStatus(): ?string
    {
        return $this->paymentDisputeStatus;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getRespondByDate(): ?string
    {
        return $this->respondByDate;
    }

    public function setAmount(?SimpleAmountInterface $value): PaymentDisputeSummaryInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setBuyerUsername(?string $value): PaymentDisputeSummaryInterface
    {
        $this->buyerUsername = $value;

        return $this;
    }

    public function setClosedDate(?string $value): PaymentDisputeSummaryInterface
    {
        $this->closedDate = $value;

        return $this;
    }

    public function setOpenDate(?string $value): PaymentDisputeSummaryInterface
    {
        $this->openDate = $value;

        return $this;
    }

    public function setOrderId(?string $value): PaymentDisputeSummaryInterface
    {
        $this->orderId = $value;

        return $this;
    }

    public function setPaymentDisputeId(?string $value): PaymentDisputeSummaryInterface
    {
        $this->paymentDisputeId = $value;

        return $this;
    }

    public function setPaymentDisputeStatus(?string $value): PaymentDisputeSummaryInterface
    {
        $this->paymentDisputeStatus = $value;

        return $this;
    }

    public function setReason(?string $value): PaymentDisputeSummaryInterface
    {
        $this->reason = $value;

        return $this;
    }

    public function setRespondByDate(?string $value): PaymentDisputeSummaryInterface
    {
        $this->respondByDate = $value;

        return $this;
    }
}
