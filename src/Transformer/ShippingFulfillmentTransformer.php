<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillment;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;

use function is_array;
use function is_string;

final class ShippingFulfillmentTransformer implements ShippingFulfillmentTransformerInterface
{
    private LineItemReferencesTransformerInterface $lineItemReferencesTransformer;

    public function __construct(LineItemReferencesTransformerInterface $lineItemReferencesTransformer)
    {
        $this->lineItemReferencesTransformer = $lineItemReferencesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingFulfillmentInterface
    {
        $shippingFulfillment = new ShippingFulfillment();

        self::applyFulfillmentId($shippingFulfillment, $data);
        $this->applyLineItems($shippingFulfillment, $data);
        self::applyShipmentTrackingNumber($shippingFulfillment, $data);
        self::applyShippedDate($shippingFulfillment, $data);
        self::applyShippingCarrierCode($shippingFulfillment, $data);

        return $shippingFulfillment;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFulfillmentId(ShippingFulfillment $shippingFulfillment, array $data): void
    {
        if (empty($data[self::KEY_FULFILLMENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_FULFILLMENT_ID])) {
            return;
        }
        $shippingFulfillment->setFulfillmentId($data[self::KEY_FULFILLMENT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItems(ShippingFulfillment $shippingFulfillment, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        $shippingFulfillment->setLineItems($this->lineItemReferencesTransformer->transform($data[self::KEY_LINE_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShipmentTrackingNumber(ShippingFulfillment $shippingFulfillment, array $data): void
    {
        if (empty($data[self::KEY_SHIPMENT_TRACKING_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPMENT_TRACKING_NUMBER])) {
            return;
        }
        $shippingFulfillment->setShipmentTrackingNumber($data[self::KEY_SHIPMENT_TRACKING_NUMBER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippedDate(ShippingFulfillment $shippingFulfillment, array $data): void
    {
        if (empty($data[self::KEY_SHIPPED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPED_DATE])) {
            return;
        }
        $shippingFulfillment->setShippedDate($data[self::KEY_SHIPPED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingCarrierCode(ShippingFulfillment $shippingFulfillment, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        $shippingFulfillment->setShippingCarrierCode($data[self::KEY_SHIPPING_CARRIER_CODE]);
    }
}
