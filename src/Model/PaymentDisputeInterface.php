<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentDisputeInterface
{
    public function getAmount(): ?SimpleAmountInterface;

    /**
     * @return array<int, string>
     */
    public function getAvailableChoices(): array;

    public function getBuyerProvided(): ?InfoFromBuyerInterface;

    public function getBuyerUsername(): ?string;

    public function getClosedDate(): ?string;

    /**
     * @return array<int, DisputeEvidenceInterface>
     */
    public function getEvidence(): array;

    /**
     * @return array<int, EvidenceRequestInterface>
     */
    public function getEvidenceRequests(): array;

    /**
     * @return array<int, OrderLineItemInterface>
     */
    public function getLineItems(): array;

    /**
     * @return array<int, MonetaryTransactionInterface>
     */
    public function getMonetaryTransactions(): array;

    public function getNote(): ?string;

    public function getOpenDate(): ?string;

    public function getOrderId(): ?string;

    public function getPaymentDisputeId(): ?string;

    public function getPaymentDisputeStatus(): ?string;

    public function getReason(): ?string;

    public function getResolution(): ?PaymentDisputeOutcomeDetailInterface;

    public function getRespondByDate(): ?string;

    public function getReturnAddress(): ?ReturnAddressInterface;

    public function getRevision(): ?int;

    public function getSellerResponse(): ?string;

    public function setAmount(?SimpleAmountInterface $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setAvailableChoices(array $value): self;

    public function setBuyerProvided(?InfoFromBuyerInterface $value): self;

    public function setBuyerUsername(?string $value): self;

    public function setClosedDate(?string $value): self;

    /**
     * @param array<int, DisputeEvidenceInterface> $value
     */
    public function setEvidence(array $value): self;

    /**
     * @param array<int, EvidenceRequestInterface> $value
     */
    public function setEvidenceRequests(array $value): self;

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): self;

    /**
     * @param array<int, MonetaryTransactionInterface> $value
     */
    public function setMonetaryTransactions(array $value): self;

    public function setNote(?string $value): self;

    public function setOpenDate(?string $value): self;

    public function setOrderId(?string $value): self;

    public function setPaymentDisputeId(?string $value): self;

    public function setPaymentDisputeStatus(?string $value): self;

    public function setReason(?string $value): self;

    public function setResolution(?PaymentDisputeOutcomeDetailInterface $value): self;

    public function setRespondByDate(?string $value): self;

    public function setReturnAddress(?ReturnAddressInterface $value): self;

    public function setRevision(?int $value): self;

    public function setSellerResponse(?string $value): self;
}
