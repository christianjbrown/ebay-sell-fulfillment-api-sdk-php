<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Order implements OrderInterface
{
    private ?BuyerInterface $buyer = null;
    private ?string $buyerCheckoutNotes = null;
    private ?CancelStatusInterface $cancelStatus = null;
    private ?string $creationDate = null;
    private ?bool $ebayCollectAndRemitTax = null;

    /**
     * @var array<int, string>
     */
    private array $fulfillmentHrefs = [];

    /**
     * @var array<int, FulfillmentStartInstructionInterface>
     */
    private array $fulfillmentStartInstructions = [];
    private ?string $lastModifiedDate = null;
    private ?string $legacyOrderId = null;

    /**
     * @var array<int, LineItemInterface>
     */
    private array $lineItems = [];
    private ?string $orderFulfillmentStatus = null;
    private ?string $orderId = null;
    private ?string $orderPaymentStatus = null;
    private ?PaymentSummaryInterface $paymentSummary = null;
    private ?PricingSummaryInterface $pricingSummary = null;
    private ?ProgramInterface $program = null;
    private ?string $salesRecordReference = null;
    private ?string $sellerId = null;
    private ?AmountInterface $totalFeeBasisAmount = null;
    private ?AmountInterface $totalMarketplaceFee = null;

    public function getBuyer(): ?BuyerInterface
    {
        return $this->buyer;
    }

    public function getBuyerCheckoutNotes(): ?string
    {
        return $this->buyerCheckoutNotes;
    }

    public function getCancelStatus(): ?CancelStatusInterface
    {
        return $this->cancelStatus;
    }

    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }

    public function getEbayCollectAndRemitTax(): ?bool
    {
        return $this->ebayCollectAndRemitTax;
    }

    /**
     * @return array<int, string>
     */
    public function getFulfillmentHrefs(): array
    {
        return $this->fulfillmentHrefs;
    }

    /**
     * @return array<int, FulfillmentStartInstructionInterface>
     */
    public function getFulfillmentStartInstructions(): array
    {
        return $this->fulfillmentStartInstructions;
    }

    public function getLastModifiedDate(): ?string
    {
        return $this->lastModifiedDate;
    }

    public function getLegacyOrderId(): ?string
    {
        return $this->legacyOrderId;
    }

    /**
     * @return array<int, LineItemInterface>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    public function getOrderFulfillmentStatus(): ?string
    {
        return $this->orderFulfillmentStatus;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getOrderPaymentStatus(): ?string
    {
        return $this->orderPaymentStatus;
    }

    public function getPaymentSummary(): ?PaymentSummaryInterface
    {
        return $this->paymentSummary;
    }

    public function getPricingSummary(): ?PricingSummaryInterface
    {
        return $this->pricingSummary;
    }

    public function getProgram(): ?ProgramInterface
    {
        return $this->program;
    }

    public function getSalesRecordReference(): ?string
    {
        return $this->salesRecordReference;
    }

    public function getSellerId(): ?string
    {
        return $this->sellerId;
    }

    public function getTotalFeeBasisAmount(): ?AmountInterface
    {
        return $this->totalFeeBasisAmount;
    }

    public function getTotalMarketplaceFee(): ?AmountInterface
    {
        return $this->totalMarketplaceFee;
    }

    public function setBuyer(?BuyerInterface $value): OrderInterface
    {
        $this->buyer = $value;

        return $this;
    }

    public function setBuyerCheckoutNotes(?string $value): OrderInterface
    {
        $this->buyerCheckoutNotes = $value;

        return $this;
    }

    public function setCancelStatus(?CancelStatusInterface $value): OrderInterface
    {
        $this->cancelStatus = $value;

        return $this;
    }

    public function setCreationDate(?string $value): OrderInterface
    {
        $this->creationDate = $value;

        return $this;
    }

    public function setEbayCollectAndRemitTax(?bool $value): OrderInterface
    {
        $this->ebayCollectAndRemitTax = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setFulfillmentHrefs(array $value): OrderInterface
    {
        $this->fulfillmentHrefs = $value;

        return $this;
    }

    /**
     * @param array<int, FulfillmentStartInstructionInterface> $value
     */
    public function setFulfillmentStartInstructions(array $value): OrderInterface
    {
        $this->fulfillmentStartInstructions = $value;

        return $this;
    }

    public function setLastModifiedDate(?string $value): OrderInterface
    {
        $this->lastModifiedDate = $value;

        return $this;
    }

    public function setLegacyOrderId(?string $value): OrderInterface
    {
        $this->legacyOrderId = $value;

        return $this;
    }

    /**
     * @param array<int, LineItemInterface> $value
     */
    public function setLineItems(array $value): OrderInterface
    {
        $this->lineItems = $value;

        return $this;
    }

    public function setOrderFulfillmentStatus(?string $value): OrderInterface
    {
        $this->orderFulfillmentStatus = $value;

        return $this;
    }

    public function setOrderId(?string $value): OrderInterface
    {
        $this->orderId = $value;

        return $this;
    }

    public function setOrderPaymentStatus(?string $value): OrderInterface
    {
        $this->orderPaymentStatus = $value;

        return $this;
    }

    public function setPaymentSummary(?PaymentSummaryInterface $value): OrderInterface
    {
        $this->paymentSummary = $value;

        return $this;
    }

    public function setPricingSummary(?PricingSummaryInterface $value): OrderInterface
    {
        $this->pricingSummary = $value;

        return $this;
    }

    public function setProgram(?ProgramInterface $value): OrderInterface
    {
        $this->program = $value;

        return $this;
    }

    public function setSalesRecordReference(?string $value): OrderInterface
    {
        $this->salesRecordReference = $value;

        return $this;
    }

    public function setSellerId(?string $value): OrderInterface
    {
        $this->sellerId = $value;

        return $this;
    }

    public function setTotalFeeBasisAmount(?AmountInterface $value): OrderInterface
    {
        $this->totalFeeBasisAmount = $value;

        return $this;
    }

    public function setTotalMarketplaceFee(?AmountInterface $value): OrderInterface
    {
        $this->totalMarketplaceFee = $value;

        return $this;
    }
}
