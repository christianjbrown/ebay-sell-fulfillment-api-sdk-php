<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentDetailsInterface;

interface ShippingFulfillmentDetailsSerializerInterface
{
    public const string KEY_LINE_ITEMS = 'lineItems';
    public const string KEY_SHIPPED_DATE = 'shippedDate';
    public const string KEY_SHIPPING_CARRIER_CODE = 'shippingCarrierCode';
    public const string KEY_TRACKING_NUMBER = 'trackingNumber';

    /**
     * @return array<string, mixed>
     */
    public function serialize(ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): array;
}
