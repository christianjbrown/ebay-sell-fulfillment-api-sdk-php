<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;

interface TrackingInfoTransformerInterface
{
    public const string KEY_SHIPMENT_TRACKING_NUMBER = 'shipmentTrackingNumber';
    public const string KEY_SHIPPING_CARRIER_CODE = 'shippingCarrierCode';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TrackingInfoInterface;
}
