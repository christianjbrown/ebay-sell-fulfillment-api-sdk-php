<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayShippingInterface;

interface EbayShippingTransformerInterface
{
    public const string KEY_SHIPPING_LABEL_PROVIDED_BY = 'shippingLabelProvidedBy';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayShippingInterface;
}
