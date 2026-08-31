<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentDisputeSummaryInterface
{
    public function getAmount(): ?SimpleAmountInterface;

    public function getBuyerUsername(): ?string;

    public function getClosedDate(): ?string;

    public function getOpenDate(): ?string;

    public function getOrderId(): ?string;

    public function getPaymentDisputeId(): ?string;

    public function getPaymentDisputeStatus(): ?string;

    public function getReason(): ?string;

    public function getRespondByDate(): ?string;

    public function setAmount(?SimpleAmountInterface $value): self;

    public function setBuyerUsername(?string $value): self;

    public function setClosedDate(?string $value): self;

    public function setOpenDate(?string $value): self;

    public function setOrderId(?string $value): self;

    public function setPaymentDisputeId(?string $value): self;

    public function setPaymentDisputeStatus(?string $value): self;

    public function setReason(?string $value): self;

    public function setRespondByDate(?string $value): self;
}
