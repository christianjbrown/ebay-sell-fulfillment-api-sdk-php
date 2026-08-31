<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DeliveryCostInterface;

interface DeliveryCostTransformerInterface
{
    public const string KEY_DISCOUNT_AMOUNT = 'discountAmount';
    public const string KEY_HANDLING_COST = 'handlingCost';
    public const string KEY_IMPORT_CHARGES = 'importCharges';
    public const string KEY_SHIPPING_COST = 'shippingCost';
    public const string KEY_SHIPPING_INTERMEDIATION_FEE = 'shippingIntermediationFee';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeliveryCostInterface;
}
