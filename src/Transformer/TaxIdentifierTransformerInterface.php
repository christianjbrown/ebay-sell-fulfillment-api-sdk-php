<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxIdentifierInterface;

interface TaxIdentifierTransformerInterface
{
    public const string KEY_ISSUING_COUNTRY = 'issuingCountry';
    public const string KEY_TAX_IDENTIFIER_TYPE = 'taxIdentifierType';
    public const string KEY_TAXPAYER_ID = 'taxpayerId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxIdentifierInterface;
}
