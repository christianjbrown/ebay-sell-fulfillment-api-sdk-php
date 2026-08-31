<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTaxInterface;

interface EbayCollectAndRemitTaxesTransformerInterface
{
    public const string ARRAY_NAME = 'ebay_collect_and_remit_tax';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, EbayCollectAndRemitTaxInterface>
     */
    public function transform(array $data): array;
}
