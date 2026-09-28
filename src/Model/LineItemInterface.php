<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface LineItemInterface
{
    /**
     * @return array<int, AppliedPromotionInterface>
     */
    public function getAppliedPromotions(): array;

    /**
     * @return array<int, PropertyInterface>
     */
    public function getCompatibilityProperties(): array;

    public function getDeliveryCost(): ?DeliveryCostInterface;

    public function getDiscountedLineItemCost(): ?AmountInterface;

    /**
     * @return array<int, EbayCollectAndRemitTaxInterface>
     */
    public function getEbayCollectAndRemitTaxes(): array;

    public function getEbayCollectedCharges(): ?EbayCollectedChargesInterface;

    public function getGiftDetails(): ?GiftDetailsInterface;

    public function getItemLocation(): ?ItemLocationInterface;

    public function getLegacyItemId(): ?string;

    public function getLegacyVariationId(): ?string;

    public function getLineItemCost(): ?AmountInterface;

    public function getLineItemFulfillmentInstructions(): ?LineItemFulfillmentInstructionsInterface;

    public function getLineItemFulfillmentStatus(): ?string;

    public function getLineItemId(): ?string;

    /**
     * @return array<int, LinkedOrderLineItemInterface>
     */
    public function getLinkedOrderLineItems(): array;

    public function getListingMarketplaceId(): ?string;

    public function getProperties(): ?LineItemPropertiesInterface;

    public function getPurchaseMarketplaceId(): ?string;

    public function getQuantity(): ?int;

    /**
     * @return array<int, LineItemRefundInterface>
     */
    public function getRefunds(): array;

    public function getSku(): ?string;

    public function getSoldFormat(): ?string;

    /**
     * @return array<int, TaxInterface>
     */
    public function getTaxes(): array;

    public function getTitle(): ?string;

    public function getTotal(): ?AmountInterface;

    /**
     * @return array<int, NameValuePairInterface>
     */
    public function getVariationAspects(): array;

    /**
     * @param array<int, AppliedPromotionInterface> $value
     */
    public function setAppliedPromotions(array $value): self;

    /**
     * @param array<int, PropertyInterface> $value
     */
    public function setCompatibilityProperties(array $value): self;

    public function setDeliveryCost(?DeliveryCostInterface $value): self;

    public function setDiscountedLineItemCost(?AmountInterface $value): self;

    /**
     * @param array<int, EbayCollectAndRemitTaxInterface> $value
     */
    public function setEbayCollectAndRemitTaxes(array $value): self;

    public function setEbayCollectedCharges(?EbayCollectedChargesInterface $value): self;

    public function setGiftDetails(?GiftDetailsInterface $value): self;

    public function setItemLocation(?ItemLocationInterface $value): self;

    public function setLegacyItemId(?string $value): self;

    public function setLegacyVariationId(?string $value): self;

    public function setLineItemCost(?AmountInterface $value): self;

    public function setLineItemFulfillmentInstructions(?LineItemFulfillmentInstructionsInterface $value): self;

    public function setLineItemFulfillmentStatus(?string $value): self;

    public function setLineItemId(?string $value): self;

    /**
     * @param array<int, LinkedOrderLineItemInterface> $value
     */
    public function setLinkedOrderLineItems(array $value): self;

    public function setListingMarketplaceId(?string $value): self;

    public function setProperties(?LineItemPropertiesInterface $value): self;

    public function setPurchaseMarketplaceId(?string $value): self;

    public function setQuantity(?int $value): self;

    /**
     * @param array<int, LineItemRefundInterface> $value
     */
    public function setRefunds(array $value): self;

    public function setSku(?string $value): self;

    public function setSoldFormat(?string $value): self;

    /**
     * @param array<int, TaxInterface> $value
     */
    public function setTaxes(array $value): self;

    public function setTitle(?string $value): self;

    public function setTotal(?AmountInterface $value): self;

    /**
     * @param array<int, NameValuePairInterface> $value
     */
    public function setVariationAspects(array $value): self;
}
