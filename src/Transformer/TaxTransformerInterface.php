<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxInterface;

interface TaxTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_TAX_TYPE = 'taxType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxInterface;
}
