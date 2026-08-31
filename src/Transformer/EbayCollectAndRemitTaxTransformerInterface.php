<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTaxInterface;

interface EbayCollectAndRemitTaxTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_COLLECTION_METHOD = 'collectionMethod';
    public const string KEY_EBAY_REFERENCE = 'ebayReference';
    public const string KEY_TAX_TYPE = 'taxType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayCollectAndRemitTaxInterface;
}
