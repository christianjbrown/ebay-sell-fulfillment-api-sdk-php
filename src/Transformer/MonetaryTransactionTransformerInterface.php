<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransactionInterface;

interface MonetaryTransactionTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_DATE = 'date';
    public const string KEY_REASON = 'reason';
    public const string KEY_TYPE = 'type';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MonetaryTransactionInterface;
}
