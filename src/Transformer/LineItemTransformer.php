<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItem;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemInterface;

use function is_array;
use function is_int;
use function is_string;

final class LineItemTransformer implements LineItemTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;
    private AppliedPromotionsTransformerInterface $appliedPromotionsTransformer;
    private DeliveryCostTransformerInterface $deliveryCostTransformer;
    private EbayCollectAndRemitTaxesTransformerInterface $ebayCollectAndRemitTaxesTransformer;
    private EbayCollectedChargesTransformerInterface $ebayCollectedChargesTransformer;
    private GiftDetailsTransformerInterface $giftDetailsTransformer;
    private ItemLocationTransformerInterface $itemLocationTransformer;
    private LineItemFulfillmentInstructionsTransformerInterface $lineItemFulfillmentInstructionsTransformer;
    private LineItemPropertiesTransformerInterface $lineItemPropertiesTransformer;
    private LineItemRefundsTransformerInterface $lineItemRefundsTransformer;
    private LinkedOrderLineItemsTransformerInterface $linkedOrderLineItemsTransformer;
    private NameValuePairsTransformerInterface $nameValuePairsTransformer;
    private TaxesTransformerInterface $taxesTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer, AppliedPromotionsTransformerInterface $appliedPromotionsTransformer, DeliveryCostTransformerInterface $deliveryCostTransformer, EbayCollectAndRemitTaxesTransformerInterface $ebayCollectAndRemitTaxesTransformer, EbayCollectedChargesTransformerInterface $ebayCollectedChargesTransformer, GiftDetailsTransformerInterface $giftDetailsTransformer, ItemLocationTransformerInterface $itemLocationTransformer, LineItemFulfillmentInstructionsTransformerInterface $lineItemFulfillmentInstructionsTransformer, LineItemPropertiesTransformerInterface $lineItemPropertiesTransformer, LineItemRefundsTransformerInterface $lineItemRefundsTransformer, LinkedOrderLineItemsTransformerInterface $linkedOrderLineItemsTransformer, NameValuePairsTransformerInterface $nameValuePairsTransformer, TaxesTransformerInterface $taxesTransformer)
    {
        $this->amountTransformer = $amountTransformer;
        $this->appliedPromotionsTransformer = $appliedPromotionsTransformer;
        $this->deliveryCostTransformer = $deliveryCostTransformer;
        $this->ebayCollectAndRemitTaxesTransformer = $ebayCollectAndRemitTaxesTransformer;
        $this->ebayCollectedChargesTransformer = $ebayCollectedChargesTransformer;
        $this->giftDetailsTransformer = $giftDetailsTransformer;
        $this->itemLocationTransformer = $itemLocationTransformer;
        $this->lineItemFulfillmentInstructionsTransformer = $lineItemFulfillmentInstructionsTransformer;
        $this->lineItemPropertiesTransformer = $lineItemPropertiesTransformer;
        $this->lineItemRefundsTransformer = $lineItemRefundsTransformer;
        $this->linkedOrderLineItemsTransformer = $linkedOrderLineItemsTransformer;
        $this->nameValuePairsTransformer = $nameValuePairsTransformer;
        $this->taxesTransformer = $taxesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemInterface
    {
        $lineItem = new LineItem();

        $this->applyAppliedPromotions($lineItem, $data);
        $this->applyDeliveryCost($lineItem, $data);
        $this->applyDiscountedLineItemCost($lineItem, $data);
        $this->applyEbayCollectAndRemitTaxes($lineItem, $data);
        $this->applyEbayCollectedCharges($lineItem, $data);
        $this->applyGiftDetails($lineItem, $data);
        $this->applyItemLocation($lineItem, $data);
        self::applyLegacyItemId($lineItem, $data);
        self::applyLegacyVariationId($lineItem, $data);
        $this->applyLineItemCost($lineItem, $data);
        $this->applyLineItemFulfillmentInstructions($lineItem, $data);
        self::applyLineItemFulfillmentStatus($lineItem, $data);
        self::applyLineItemId($lineItem, $data);
        $this->applyLinkedOrderLineItems($lineItem, $data);
        self::applyListingMarketplaceId($lineItem, $data);
        $this->applyProperties($lineItem, $data);
        self::applyPurchaseMarketplaceId($lineItem, $data);
        self::applyQuantity($lineItem, $data);
        $this->applyRefunds($lineItem, $data);
        self::applySku($lineItem, $data);
        self::applySoldFormat($lineItem, $data);
        $this->applyTaxes($lineItem, $data);
        self::applyTitle($lineItem, $data);
        $this->applyTotal($lineItem, $data);
        $this->applyVariationAspects($lineItem, $data);

        return $lineItem;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAppliedPromotions(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_APPLIED_PROMOTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_APPLIED_PROMOTIONS])) {
            return;
        }
        $lineItem->setAppliedPromotions($this->appliedPromotionsTransformer->transform($data[self::KEY_APPLIED_PROMOTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeliveryCost(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_DELIVERY_COST])) {
            return;
        }
        if (!is_array($data[self::KEY_DELIVERY_COST])) {
            return;
        }
        $lineItem->setDeliveryCost($this->deliveryCostTransformer->transform($data[self::KEY_DELIVERY_COST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDiscountedLineItemCost(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_DISCOUNTED_LINE_ITEM_COST])) {
            return;
        }
        if (!is_array($data[self::KEY_DISCOUNTED_LINE_ITEM_COST])) {
            return;
        }
        $lineItem->setDiscountedLineItemCost($this->amountTransformer->transform($data[self::KEY_DISCOUNTED_LINE_ITEM_COST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEbayCollectAndRemitTaxes(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAXES])) {
            return;
        }
        if (!is_array($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAXES])) {
            return;
        }
        $lineItem->setEbayCollectAndRemitTaxes($this->ebayCollectAndRemitTaxesTransformer->transform($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAXES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEbayCollectedCharges(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_EBAY_COLLECTED_CHARGES])) {
            return;
        }
        if (!is_array($data[self::KEY_EBAY_COLLECTED_CHARGES])) {
            return;
        }
        $lineItem->setEbayCollectedCharges($this->ebayCollectedChargesTransformer->transform($data[self::KEY_EBAY_COLLECTED_CHARGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyGiftDetails(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_GIFT_DETAILS])) {
            return;
        }
        if (!is_array($data[self::KEY_GIFT_DETAILS])) {
            return;
        }
        $lineItem->setGiftDetails($this->giftDetailsTransformer->transform($data[self::KEY_GIFT_DETAILS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemLocation(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_ITEM_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEM_LOCATION])) {
            return;
        }
        $lineItem->setItemLocation($this->itemLocationTransformer->transform($data[self::KEY_ITEM_LOCATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegacyItemId(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        $lineItem->setLegacyItemId($data[self::KEY_LEGACY_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegacyVariationId(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LEGACY_VARIATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LEGACY_VARIATION_ID])) {
            return;
        }
        $lineItem->setLegacyVariationId($data[self::KEY_LEGACY_VARIATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItemCost(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_COST])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEM_COST])) {
            return;
        }
        $lineItem->setLineItemCost($this->amountTransformer->transform($data[self::KEY_LINE_ITEM_COST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItemFulfillmentInstructions(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_FULFILLMENT_INSTRUCTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEM_FULFILLMENT_INSTRUCTIONS])) {
            return;
        }
        $lineItem->setLineItemFulfillmentInstructions($this->lineItemFulfillmentInstructionsTransformer->transform($data[self::KEY_LINE_ITEM_FULFILLMENT_INSTRUCTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLineItemFulfillmentStatus(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_FULFILLMENT_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_LINE_ITEM_FULFILLMENT_STATUS])) {
            return;
        }
        $lineItem->setLineItemFulfillmentStatus($data[self::KEY_LINE_ITEM_FULFILLMENT_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLineItemId(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        $lineItem->setLineItemId($data[self::KEY_LINE_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLinkedOrderLineItems(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LINKED_ORDER_LINE_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINKED_ORDER_LINE_ITEMS])) {
            return;
        }
        $lineItem->setLinkedOrderLineItems($this->linkedOrderLineItemsTransformer->transform($data[self::KEY_LINKED_ORDER_LINE_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyListingMarketplaceId(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        $lineItem->setListingMarketplaceId($data[self::KEY_LISTING_MARKETPLACE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProperties(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_PROPERTIES])) {
            return;
        }
        if (!is_array($data[self::KEY_PROPERTIES])) {
            return;
        }
        $lineItem->setProperties($this->lineItemPropertiesTransformer->transform($data[self::KEY_PROPERTIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPurchaseMarketplaceId(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_PURCHASE_MARKETPLACE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PURCHASE_MARKETPLACE_ID])) {
            return;
        }
        $lineItem->setPurchaseMarketplaceId($data[self::KEY_PURCHASE_MARKETPLACE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyQuantity(LineItem $lineItem, array $data): void
    {
        if (!isset($data[self::KEY_QUANTITY])) {
            return;
        }
        if (!is_int($data[self::KEY_QUANTITY])) {
            return;
        }
        $lineItem->setQuantity($data[self::KEY_QUANTITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRefunds(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_REFUNDS])) {
            return;
        }
        if (!is_array($data[self::KEY_REFUNDS])) {
            return;
        }
        $lineItem->setRefunds($this->lineItemRefundsTransformer->transform($data[self::KEY_REFUNDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySku(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_SKU])) {
            return;
        }
        if (!is_string($data[self::KEY_SKU])) {
            return;
        }
        $lineItem->setSku($data[self::KEY_SKU]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySoldFormat(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_SOLD_FORMAT])) {
            return;
        }
        if (!is_string($data[self::KEY_SOLD_FORMAT])) {
            return;
        }
        $lineItem->setSoldFormat($data[self::KEY_SOLD_FORMAT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTaxes(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_TAXES])) {
            return;
        }
        if (!is_array($data[self::KEY_TAXES])) {
            return;
        }
        $lineItem->setTaxes($this->taxesTransformer->transform($data[self::KEY_TAXES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $lineItem->setTitle($data[self::KEY_TITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTotal(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_TOTAL])) {
            return;
        }
        if (!is_array($data[self::KEY_TOTAL])) {
            return;
        }
        $lineItem->setTotal($this->amountTransformer->transform($data[self::KEY_TOTAL]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVariationAspects(LineItem $lineItem, array $data): void
    {
        if (empty($data[self::KEY_VARIATION_ASPECTS])) {
            return;
        }
        if (!is_array($data[self::KEY_VARIATION_ASPECTS])) {
            return;
        }
        $lineItem->setVariationAspects($this->nameValuePairsTransformer->transform($data[self::KEY_VARIATION_ASPECTS]));
    }
}
