<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemInterface;

interface LineItemTransformerInterface
{
    public const string KEY_APPLIED_PROMOTIONS = 'appliedPromotions';
    public const string KEY_COMPATIBILITY_PROPERTIES = 'compatibilityProperties';
    public const string KEY_DELIVERY_COST = 'deliveryCost';
    public const string KEY_DISCOUNTED_LINE_ITEM_COST = 'discountedLineItemCost';
    public const string KEY_EBAY_COLLECT_AND_REMIT_TAXES = 'ebayCollectAndRemitTaxes';
    public const string KEY_EBAY_COLLECTED_CHARGES = 'ebayCollectedCharges';
    public const string KEY_GIFT_DETAILS = 'giftDetails';
    public const string KEY_ITEM_LOCATION = 'itemLocation';
    public const string KEY_LEGACY_ITEM_ID = 'legacyItemId';
    public const string KEY_LEGACY_VARIATION_ID = 'legacyVariationId';
    public const string KEY_LINE_ITEM_COST = 'lineItemCost';
    public const string KEY_LINE_ITEM_FULFILLMENT_INSTRUCTIONS = 'lineItemFulfillmentInstructions';
    public const string KEY_LINE_ITEM_FULFILLMENT_STATUS = 'lineItemFulfillmentStatus';
    public const string KEY_LINE_ITEM_ID = 'lineItemId';
    public const string KEY_LINKED_ORDER_LINE_ITEMS = 'linkedOrderLineItems';
    public const string KEY_LISTING_MARKETPLACE_ID = 'listingMarketplaceId';
    public const string KEY_PROPERTIES = 'properties';
    public const string KEY_PURCHASE_MARKETPLACE_ID = 'purchaseMarketplaceId';
    public const string KEY_QUANTITY = 'quantity';
    public const string KEY_REFUNDS = 'refunds';
    public const string KEY_SKU = 'sku';
    public const string KEY_SOLD_FORMAT = 'soldFormat';
    public const string KEY_TAXES = 'taxes';
    public const string KEY_TITLE = 'title';
    public const string KEY_TOTAL = 'total';
    public const string KEY_VARIATION_ASPECTS = 'variationAspects';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemInterface;
}
