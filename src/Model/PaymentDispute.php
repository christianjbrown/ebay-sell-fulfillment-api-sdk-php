<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PaymentDispute implements PaymentDisputeInterface
{
    private ?SimpleAmountInterface $amount = null;

    /**
     * @var array<int, string>
     */
    private array $availableChoices = [];
    private ?InfoFromBuyerInterface $buyerProvided = null;
    private ?string $buyerUsername = null;
    private ?string $closedDate = null;

    /**
     * @var array<int, DisputeEvidenceInterface>
     */
    private array $evidence = [];

    /**
     * @var array<int, EvidenceRequestInterface>
     */
    private array $evidenceRequests = [];

    /**
     * @var array<int, OrderLineItemInterface>
     */
    private array $lineItems = [];

    /**
     * @var array<int, MonetaryTransactionInterface>
     */
    private array $monetaryTransactions = [];
    private ?string $note = null;
    private ?string $openDate = null;
    private ?string $orderId = null;
    private ?string $paymentDisputeId = null;
    private ?string $paymentDisputeStatus = null;
    private ?string $reason = null;
    private ?PaymentDisputeOutcomeDetailInterface $resolution = null;
    private ?string $respondByDate = null;
    private ?ReturnAddressInterface $returnAddress = null;
    private ?int $revision = null;
    private ?string $sellerResponse = null;

    public function getAmount(): ?SimpleAmountInterface
    {
        return $this->amount;
    }

    /**
     * @return array<int, string>
     */
    public function getAvailableChoices(): array
    {
        return $this->availableChoices;
    }

    public function getBuyerProvided(): ?InfoFromBuyerInterface
    {
        return $this->buyerProvided;
    }

    public function getBuyerUsername(): ?string
    {
        return $this->buyerUsername;
    }

    public function getClosedDate(): ?string
    {
        return $this->closedDate;
    }

    /**
     * @return array<int, DisputeEvidenceInterface>
     */
    public function getEvidence(): array
    {
        return $this->evidence;
    }

    /**
     * @return array<int, EvidenceRequestInterface>
     */
    public function getEvidenceRequests(): array
    {
        return $this->evidenceRequests;
    }

    /**
     * @return array<int, OrderLineItemInterface>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    /**
     * @return array<int, MonetaryTransactionInterface>
     */
    public function getMonetaryTransactions(): array
    {
        return $this->monetaryTransactions;
    }

    public function getNote(): ?string
    {
        return $this->note;
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

    public function getResolution(): ?PaymentDisputeOutcomeDetailInterface
    {
        return $this->resolution;
    }

    public function getRespondByDate(): ?string
    {
        return $this->respondByDate;
    }

    public function getReturnAddress(): ?ReturnAddressInterface
    {
        return $this->returnAddress;
    }

    public function getRevision(): ?int
    {
        return $this->revision;
    }

    public function getSellerResponse(): ?string
    {
        return $this->sellerResponse;
    }

    public function setAmount(?SimpleAmountInterface $value): PaymentDisputeInterface
    {
        $this->amount = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setAvailableChoices(array $value): PaymentDisputeInterface
    {
        $this->availableChoices = $value;

        return $this;
    }

    public function setBuyerProvided(?InfoFromBuyerInterface $value): PaymentDisputeInterface
    {
        $this->buyerProvided = $value;

        return $this;
    }

    public function setBuyerUsername(?string $value): PaymentDisputeInterface
    {
        $this->buyerUsername = $value;

        return $this;
    }

    public function setClosedDate(?string $value): PaymentDisputeInterface
    {
        $this->closedDate = $value;

        return $this;
    }

    /**
     * @param array<int, DisputeEvidenceInterface> $value
     */
    public function setEvidence(array $value): PaymentDisputeInterface
    {
        $this->evidence = $value;

        return $this;
    }

    /**
     * @param array<int, EvidenceRequestInterface> $value
     */
    public function setEvidenceRequests(array $value): PaymentDisputeInterface
    {
        $this->evidenceRequests = $value;

        return $this;
    }

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): PaymentDisputeInterface
    {
        $this->lineItems = $value;

        return $this;
    }

    /**
     * @param array<int, MonetaryTransactionInterface> $value
     */
    public function setMonetaryTransactions(array $value): PaymentDisputeInterface
    {
        $this->monetaryTransactions = $value;

        return $this;
    }

    public function setNote(?string $value): PaymentDisputeInterface
    {
        $this->note = $value;

        return $this;
    }

    public function setOpenDate(?string $value): PaymentDisputeInterface
    {
        $this->openDate = $value;

        return $this;
    }

    public function setOrderId(?string $value): PaymentDisputeInterface
    {
        $this->orderId = $value;

        return $this;
    }

    public function setPaymentDisputeId(?string $value): PaymentDisputeInterface
    {
        $this->paymentDisputeId = $value;

        return $this;
    }

    public function setPaymentDisputeStatus(?string $value): PaymentDisputeInterface
    {
        $this->paymentDisputeStatus = $value;

        return $this;
    }

    public function setReason(?string $value): PaymentDisputeInterface
    {
        $this->reason = $value;

        return $this;
    }

    public function setResolution(?PaymentDisputeOutcomeDetailInterface $value): PaymentDisputeInterface
    {
        $this->resolution = $value;

        return $this;
    }

    public function setRespondByDate(?string $value): PaymentDisputeInterface
    {
        $this->respondByDate = $value;

        return $this;
    }

    public function setReturnAddress(?ReturnAddressInterface $value): PaymentDisputeInterface
    {
        $this->returnAddress = $value;

        return $this;
    }

    public function setRevision(?int $value): PaymentDisputeInterface
    {
        $this->revision = $value;

        return $this;
    }

    public function setSellerResponse(?string $value): PaymentDisputeInterface
    {
        $this->sellerResponse = $value;

        return $this;
    }
}
