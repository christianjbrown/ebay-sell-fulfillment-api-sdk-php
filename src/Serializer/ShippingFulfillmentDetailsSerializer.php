<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentDetailsInterface;

final class ShippingFulfillmentDetailsSerializer implements ShippingFulfillmentDetailsSerializerInterface
{
    private LineItemReferencesSerializerInterface $lineItemReferencesSerializer;

    public function __construct(LineItemReferencesSerializerInterface $lineItemReferencesSerializer)
    {
        $this->lineItemReferencesSerializer = $lineItemReferencesSerializer;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): array
    {
        $data = [];

        $data = $this->applyLineItems($data, $shippingFulfillmentDetails);
        $data = self::applyShippedDate($data, $shippingFulfillmentDetails);
        $data = self::applyShippingCarrierCode($data, $shippingFulfillmentDetails);
        $data = self::applyTrackingNumber($data, $shippingFulfillmentDetails);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyLineItems(array $data, ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): array
    {
        $value = $shippingFulfillmentDetails->getLineItems();
        if (empty($value)) {
            return $data;
        }
        $data[self::KEY_LINE_ITEMS] = $this->lineItemReferencesSerializer->serialize($value);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyShippedDate(array $data, ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): array
    {
        $value = $shippingFulfillmentDetails->getShippedDate();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_SHIPPED_DATE] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyShippingCarrierCode(array $data, ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): array
    {
        $value = $shippingFulfillmentDetails->getShippingCarrierCode();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_SHIPPING_CARRIER_CODE] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyTrackingNumber(array $data, ShippingFulfillmentDetailsInterface $shippingFulfillmentDetails): array
    {
        $value = $shippingFulfillmentDetails->getTrackingNumber();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_TRACKING_NUMBER] = $value;

        return $data;
    }
}
