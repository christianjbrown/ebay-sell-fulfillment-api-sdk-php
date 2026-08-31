<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingStep;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingStepInterface;

use function is_array;
use function is_string;

final class ShippingStepTransformer implements ShippingStepTransformerInterface
{
    private ExtendedContactTransformerInterface $extendedContactTransformer;

    public function __construct(ExtendedContactTransformerInterface $extendedContactTransformer)
    {
        $this->extendedContactTransformer = $extendedContactTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingStepInterface
    {
        $shippingStep = new ShippingStep();

        self::applyShippingCarrierCode($shippingStep, $data);
        self::applyShippingServiceCode($shippingStep, $data);
        $this->applyShipTo($shippingStep, $data);
        self::applyShipToReferenceId($shippingStep, $data);

        return $shippingStep;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingCarrierCode(ShippingStep $shippingStep, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_CARRIER_CODE])) {
            return;
        }
        $shippingStep->setShippingCarrierCode($data[self::KEY_SHIPPING_CARRIER_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingServiceCode(ShippingStep $shippingStep, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_SERVICE_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_SERVICE_CODE])) {
            return;
        }
        $shippingStep->setShippingServiceCode($data[self::KEY_SHIPPING_SERVICE_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShipTo(ShippingStep $shippingStep, array $data): void
    {
        if (empty($data[self::KEY_SHIP_TO])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIP_TO])) {
            return;
        }
        $shippingStep->setShipTo($this->extendedContactTransformer->transform($data[self::KEY_SHIP_TO]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShipToReferenceId(ShippingStep $shippingStep, array $data): void
    {
        if (empty($data[self::KEY_SHIP_TO_REFERENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIP_TO_REFERENCE_ID])) {
            return;
        }
        $shippingStep->setShipToReferenceId($data[self::KEY_SHIP_TO_REFERENCE_ID]);
    }
}
