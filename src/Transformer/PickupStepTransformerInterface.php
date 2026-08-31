<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PickupStepInterface;

interface PickupStepTransformerInterface
{
    public const string KEY_MERCHANT_LOCATION_KEY = 'merchantLocationKey';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PickupStepInterface;
}
