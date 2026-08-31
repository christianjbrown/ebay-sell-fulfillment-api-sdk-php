<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedChargesInterface;

interface EbayCollectedChargesTransformerInterface
{
    public const string KEY_EBAY_SHIPPING = 'ebayShipping';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayCollectedChargesInterface;
}
