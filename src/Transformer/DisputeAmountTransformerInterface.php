<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeAmountInterface;

interface DisputeAmountTransformerInterface
{
    public const string KEY_CONVERTED_FROM_CURRENCY = 'convertedFromCurrency';
    public const string KEY_CONVERTED_FROM_VALUE = 'convertedFromValue';
    public const string KEY_CURRENCY = 'currency';
    public const string KEY_EXCHANGE_RATE = 'exchangeRate';
    public const string KEY_VALUE = 'value';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DisputeAmountInterface;
}
