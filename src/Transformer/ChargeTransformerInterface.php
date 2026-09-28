<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ChargeInterface;

interface ChargeTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_CHARGE_TYPE = 'chargeType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ChargeInterface;
}
