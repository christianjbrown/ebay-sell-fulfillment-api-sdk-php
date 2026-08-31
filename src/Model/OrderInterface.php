<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface OrderInterface
{
    public function getBuyer(): ?BuyerInterface;

    public function getBuyerCheckoutNotes(): ?string;

    public function getCancelStatus(): ?CancelStatusInterface;

    public function getCreationDate(): ?string;

    public function getEbayCollectAndRemitTax(): ?bool;

    /**
     * @return array<int, string>
     */
    public function getFulfillmentHrefs(): array;

    /**
     * @return array<int, FulfillmentStartInstructionInterface>
     */
    public function getFulfillmentStartInstructions(): array;

    public function getLastModifiedDate(): ?string;

    public function getLegacyOrderId(): ?string;

    /**
     * @return array<int, LineItemInterface>
     */
    public function getLineItems(): array;

    public function getOrderFulfillmentStatus(): ?string;

    public function getOrderId(): ?string;

    public function getOrderPaymentStatus(): ?string;

    public function getPaymentSummary(): ?PaymentSummaryInterface;

    public function getPricingSummary(): ?PricingSummaryInterface;

    public function getProgram(): ?ProgramInterface;

    public function getSalesRecordReference(): ?string;

    public function getSellerId(): ?string;

    public function getTotalFeeBasisAmount(): ?AmountInterface;

    public function getTotalMarketplaceFee(): ?AmountInterface;

    public function setBuyer(?BuyerInterface $value): self;

    public function setBuyerCheckoutNotes(?string $value): self;

    public function setCancelStatus(?CancelStatusInterface $value): self;

    public function setCreationDate(?string $value): self;

    public function setEbayCollectAndRemitTax(?bool $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setFulfillmentHrefs(array $value): self;

    /**
     * @param array<int, FulfillmentStartInstructionInterface> $value
     */
    public function setFulfillmentStartInstructions(array $value): self;

    public function setLastModifiedDate(?string $value): self;

    public function setLegacyOrderId(?string $value): self;

    /**
     * @param array<int, LineItemInterface> $value
     */
    public function setLineItems(array $value): self;

    public function setOrderFulfillmentStatus(?string $value): self;

    public function setOrderId(?string $value): self;

    public function setOrderPaymentStatus(?string $value): self;

    public function setPaymentSummary(?PaymentSummaryInterface $value): self;

    public function setPricingSummary(?PricingSummaryInterface $value): self;

    public function setProgram(?ProgramInterface $value): self;

    public function setSalesRecordReference(?string $value): self;

    public function setSellerId(?string $value): self;

    public function setTotalFeeBasisAmount(?AmountInterface $value): self;

    public function setTotalMarketplaceFee(?AmountInterface $value): self;
}
