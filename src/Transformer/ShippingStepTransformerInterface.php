<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingStepInterface;

interface ShippingStepTransformerInterface
{
    public const string KEY_SHIP_TO = 'shipTo';
    public const string KEY_SHIP_TO_REFERENCE_ID = 'shipToReferenceId';
    public const string KEY_SHIPPING_CARRIER_CODE = 'shippingCarrierCode';
    public const string KEY_SHIPPING_SERVICE_CODE = 'shippingServiceCode';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingStepInterface;
}
