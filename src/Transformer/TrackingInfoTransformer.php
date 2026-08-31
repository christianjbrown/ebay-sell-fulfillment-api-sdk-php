<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfo;
use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;

use function is_string;

final class TrackingInfoTransformer implements TrackingInfoTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TrackingInfoInterface
    {
        $trackingInfo = new TrackingInfo();

        self::applyShipmentTrackingNumber($trackingInfo, $data);
        self::applyShippingCarrierCode($trackingInfo, $data);

        return $trackingInfo;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShipmentTrackingNumber(TrackingInfo $trackingInfo, array $data): void
    {
        if (empty($data[self::KEY_SHIPMENT_TRACKING_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPMENT_TRACKING_NUMBER])) {
            return;
        }
        $trackingInfo->setShipmentTrackingNumber($data[self::KEY_SHIPMENT_TRACKING_NUMBER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingCarrierCode(TrackingInfo $trackingInfo, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        $trackingInfo->setShippingCarrierCode($data[self::KEY_SHIPPING_CARRIER_CODE]);
    }
}
