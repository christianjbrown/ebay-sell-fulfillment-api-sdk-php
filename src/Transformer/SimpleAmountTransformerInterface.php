<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;

interface SimpleAmountTransformerInterface
{
    public const string KEY_CURRENCY = 'currency';
    public const string KEY_VALUE = 'value';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SimpleAmountInterface;
}
