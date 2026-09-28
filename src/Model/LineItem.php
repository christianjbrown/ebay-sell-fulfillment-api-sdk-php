<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class LineItem implements LineItemInterface
{
    /**
     * @var array<int, AppliedPromotionInterface>
     */
    private array $appliedPromotions = [];

    /**
     * @var array<int, PropertyInterface>
     */
    private array $compatibilityProperties = [];
    private ?DeliveryCostInterface $deliveryCost = null;
    private ?AmountInterface $discountedLineItemCost = null;

    /**
     * @var array<int, EbayCollectAndRemitTaxInterface>
     */
    private array $ebayCollectAndRemitTaxes = [];
    private ?EbayCollectedChargesInterface $ebayCollectedCharges = null;
    private ?GiftDetailsInterface $giftDetails = null;
    private ?ItemLocationInterface $itemLocation = null;
    private ?string $legacyItemId = null;
    private ?string $legacyVariationId = null;
    private ?AmountInterface $lineItemCost = null;
    private ?LineItemFulfillmentInstructionsInterface $lineItemFulfillmentInstructions = null;
    private ?string $lineItemFulfillmentStatus = null;
    private ?string $lineItemId = null;

    /**
     * @var array<int, LinkedOrderLineItemInterface>
     */
    private array $linkedOrderLineItems = [];
    private ?string $listingMarketplaceId = null;
    private ?LineItemPropertiesInterface $properties = null;
    private ?string $purchaseMarketplaceId = null;
    private ?int $quantity = null;

    /**
     * @var array<int, LineItemRefundInterface>
     */
    private array $refunds = [];
    private ?string $sku = null;
    private ?string $soldFormat = null;

    /**
     * @var array<int, TaxInterface>
     */
    private array $taxes = [];
    private ?string $title = null;
    private ?AmountInterface $total = null;

    /**
     * @var array<int, NameValuePairInterface>
     */
    private array $variationAspects = [];

    /**
     * @return array<int, AppliedPromotionInterface>
     */
    public function getAppliedPromotions(): array
    {
        return $this->appliedPromotions;
    }

    /**
     * @return array<int, PropertyInterface>
     */
    public function getCompatibilityProperties(): array
    {
        return $this->compatibilityProperties;
    }

    public function getDeliveryCost(): ?DeliveryCostInterface
    {
        return $this->deliveryCost;
    }

    public function getDiscountedLineItemCost(): ?AmountInterface
    {
        return $this->discountedLineItemCost;
    }

    /**
     * @return array<int, EbayCollectAndRemitTaxInterface>
     */
    public function getEbayCollectAndRemitTaxes(): array
    {
        return $this->ebayCollectAndRemitTaxes;
    }

    public function getEbayCollectedCharges(): ?EbayCollectedChargesInterface
    {
        return $this->ebayCollectedCharges;
    }

    public function getGiftDetails(): ?GiftDetailsInterface
    {
        return $this->giftDetails;
    }

    public function getItemLocation(): ?ItemLocationInterface
    {
        return $this->itemLocation;
    }

    public function getLegacyItemId(): ?string
    {
        return $this->legacyItemId;
    }

    public function getLegacyVariationId(): ?string
    {
        return $this->legacyVariationId;
    }

    public function getLineItemCost(): ?AmountInterface
    {
        return $this->lineItemCost;
    }

    public function getLineItemFulfillmentInstructions(): ?LineItemFulfillmentInstructionsInterface
    {
        return $this->lineItemFulfillmentInstructions;
    }

    public function getLineItemFulfillmentStatus(): ?string
    {
        return $this->lineItemFulfillmentStatus;
    }

    public function getLineItemId(): ?string
    {
        return $this->lineItemId;
    }

    /**
     * @return array<int, LinkedOrderLineItemInterface>
     */
    public function getLinkedOrderLineItems(): array
    {
        return $this->linkedOrderLineItems;
    }

    public function getListingMarketplaceId(): ?string
    {
        return $this->listingMarketplaceId;
    }

    public function getProperties(): ?LineItemPropertiesInterface
    {
        return $this->properties;
    }

    public function getPurchaseMarketplaceId(): ?string
    {
        return $this->purchaseMarketplaceId;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @return array<int, LineItemRefundInterface>
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getSoldFormat(): ?string
    {
        return $this->soldFormat;
    }

    /**
     * @return array<int, TaxInterface>
     */
    public function getTaxes(): array
    {
        return $this->taxes;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getTotal(): ?AmountInterface
    {
        return $this->total;
    }

    /**
     * @return array<int, NameValuePairInterface>
     */
    public function getVariationAspects(): array
    {
        return $this->variationAspects;
    }

    /**
     * @param array<int, AppliedPromotionInterface> $value
     */
    public function setAppliedPromotions(array $value): LineItemInterface
    {
        $this->appliedPromotions = $value;

        return $this;
    }

    /**
     * @param array<int, PropertyInterface> $value
     */
    public function setCompatibilityProperties(array $value): LineItemInterface
    {
        $this->compatibilityProperties = $value;

        return $this;
    }

    public function setDeliveryCost(?DeliveryCostInterface $value): LineItemInterface
    {
        $this->deliveryCost = $value;

        return $this;
    }

    public function setDiscountedLineItemCost(?AmountInterface $value): LineItemInterface
    {
        $this->discountedLineItemCost = $value;

        return $this;
    }

    /**
     * @param array<int, EbayCollectAndRemitTaxInterface> $value
     */
    public function setEbayCollectAndRemitTaxes(array $value): LineItemInterface
    {
        $this->ebayCollectAndRemitTaxes = $value;

        return $this;
    }

    public function setEbayCollectedCharges(?EbayCollectedChargesInterface $value): LineItemInterface
    {
        $this->ebayCollectedCharges = $value;

        return $this;
    }

    public function setGiftDetails(?GiftDetailsInterface $value): LineItemInterface
    {
        $this->giftDetails = $value;

        return $this;
    }

    public function setItemLocation(?ItemLocationInterface $value): LineItemInterface
    {
        $this->itemLocation = $value;

        return $this;
    }

    public function setLegacyItemId(?string $value): LineItemInterface
    {
        $this->legacyItemId = $value;

        return $this;
    }

    public function setLegacyVariationId(?string $value): LineItemInterface
    {
        $this->legacyVariationId = $value;

        return $this;
    }

    public function setLineItemCost(?AmountInterface $value): LineItemInterface
    {
        $this->lineItemCost = $value;

        return $this;
    }

    public function setLineItemFulfillmentInstructions(?LineItemFulfillmentInstructionsInterface $value): LineItemInterface
    {
        $this->lineItemFulfillmentInstructions = $value;

        return $this;
    }

    public function setLineItemFulfillmentStatus(?string $value): LineItemInterface
    {
        $this->lineItemFulfillmentStatus = $value;

        return $this;
    }

    public function setLineItemId(?string $value): LineItemInterface
    {
        $this->lineItemId = $value;

        return $this;
    }

    /**
     * @param array<int, LinkedOrderLineItemInterface> $value
     */
    public function setLinkedOrderLineItems(array $value): LineItemInterface
    {
        $this->linkedOrderLineItems = $value;

        return $this;
    }

    public function setListingMarketplaceId(?string $value): LineItemInterface
    {
        $this->listingMarketplaceId = $value;

        return $this;
    }

    public function setProperties(?LineItemPropertiesInterface $value): LineItemInterface
    {
        $this->properties = $value;

        return $this;
    }

    public function setPurchaseMarketplaceId(?string $value): LineItemInterface
    {
        $this->purchaseMarketplaceId = $value;

        return $this;
    }

    public function setQuantity(?int $value): LineItemInterface
    {
        $this->quantity = $value;

        return $this;
    }

    /**
     * @param array<int, LineItemRefundInterface> $value
     */
    public function setRefunds(array $value): LineItemInterface
    {
        $this->refunds = $value;

        return $this;
    }

    public function setSku(?string $value): LineItemInterface
    {
        $this->sku = $value;

        return $this;
    }

    public function setSoldFormat(?string $value): LineItemInterface
    {
        $this->soldFormat = $value;

        return $this;
    }

    /**
     * @param array<int, TaxInterface> $value
     */
    public function setTaxes(array $value): LineItemInterface
    {
        $this->taxes = $value;

        return $this;
    }

    public function setTitle(?string $value): LineItemInterface
    {
        $this->title = $value;

        return $this;
    }

    public function setTotal(?AmountInterface $value): LineItemInterface
    {
        $this->total = $value;

        return $this;
    }

    /**
     * @param array<int, NameValuePairInterface> $value
     */
    public function setVariationAspects(array $value): LineItemInterface
    {
        $this->variationAspects = $value;

        return $this;
    }
}
