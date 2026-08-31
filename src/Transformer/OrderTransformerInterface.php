<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;

interface OrderTransformerInterface
{
    public const string KEY_BUYER = 'buyer';
    public const string KEY_BUYER_CHECKOUT_NOTES = 'buyerCheckoutNotes';
    public const string KEY_CANCEL_STATUS = 'cancelStatus';
    public const string KEY_CREATION_DATE = 'creationDate';
    public const string KEY_EBAY_COLLECT_AND_REMIT_TAX = 'ebayCollectAndRemitTax';
    public const string KEY_FULFILLMENT_HREFS = 'fulfillmentHrefs';
    public const string KEY_FULFILLMENT_START_INSTRUCTIONS = 'fulfillmentStartInstructions';
    public const string KEY_LAST_MODIFIED_DATE = 'lastModifiedDate';
    public const string KEY_LEGACY_ORDER_ID = 'legacyOrderId';
    public const string KEY_LINE_ITEMS = 'lineItems';
    public const string KEY_ORDER_FULFILLMENT_STATUS = 'orderFulfillmentStatus';
    public const string KEY_ORDER_ID = 'orderId';
    public const string KEY_ORDER_PAYMENT_STATUS = 'orderPaymentStatus';
    public const string KEY_PAYMENT_SUMMARY = 'paymentSummary';
    public const string KEY_PRICING_SUMMARY = 'pricingSummary';
    public const string KEY_PROGRAM = 'program';
    public const string KEY_SALES_RECORD_REFERENCE = 'salesRecordReference';
    public const string KEY_SELLER_ID = 'sellerId';
    public const string KEY_TOTAL_FEE_BASIS_AMOUNT = 'totalFeeBasisAmount';
    public const string KEY_TOTAL_MARKETPLACE_FEE = 'totalMarketplaceFee';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderInterface;
}
