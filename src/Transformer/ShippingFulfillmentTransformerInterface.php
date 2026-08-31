<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;

interface ShippingFulfillmentTransformerInterface
{
    public const string KEY_FULFILLMENT_ID = 'fulfillmentId';
    public const string KEY_LINE_ITEMS = 'lineItems';
    public const string KEY_SHIPMENT_TRACKING_NUMBER = 'shipmentTrackingNumber';
    public const string KEY_SHIPPED_DATE = 'shippedDate';
    public const string KEY_SHIPPING_CARRIER_CODE = 'shippingCarrierCode';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingFulfillmentInterface;
}
