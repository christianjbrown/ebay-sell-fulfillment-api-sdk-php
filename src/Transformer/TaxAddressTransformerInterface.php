<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxAddressInterface;

interface TaxAddressTransformerInterface
{
    public const string KEY_CITY = 'city';
    public const string KEY_COUNTRY_CODE = 'countryCode';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string KEY_STATE_OR_PROVINCE = 'stateOrProvince';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxAddressInterface;
}
