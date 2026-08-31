<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PickupStep;
use ChristianBrown\EBay\SellFulfillment\Model\PickupStepInterface;

use function is_string;

final class PickupStepTransformer implements PickupStepTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PickupStepInterface
    {
        $pickupStep = new PickupStep();

        self::applyMerchantLocationKey($pickupStep, $data);

        return $pickupStep;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMerchantLocationKey(PickupStep $pickupStep, array $data): void
    {
        if (empty($data[self::KEY_MERCHANT_LOCATION_KEY])) {
            return;
        }
        if (!is_string($data[self::KEY_MERCHANT_LOCATION_KEY])) {
            return;
        }
        $pickupStep->setMerchantLocationKey($data[self::KEY_MERCHANT_LOCATION_KEY]);
    }
}
