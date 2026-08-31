<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayInternationalShippingInterface;

interface EbayInternationalShippingTransformerInterface
{
    public const string KEY_RETURNS_MANAGED_BY = 'returnsManagedBy';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayInternationalShippingInterface;
}
