<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayFulfillmentProgramInterface;

interface EbayFulfillmentProgramTransformerInterface
{
    public const string KEY_FULFILLED_BY = 'fulfilledBy';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayFulfillmentProgramInterface;
}
