<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddressInterface;

interface ReturnAddressTransformerInterface
{
    public const string KEY_ADDRESS_LINE1 = 'addressLine1';
    public const string KEY_ADDRESS_LINE2 = 'addressLine2';
    public const string KEY_CITY = 'city';
    public const string KEY_COUNTRY = 'country';
    public const string KEY_COUNTY = 'county';
    public const string KEY_FULL_NAME = 'fullName';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string KEY_PRIMARY_PHONE = 'primaryPhone';
    public const string KEY_STATE_OR_PROVINCE = 'stateOrProvince';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReturnAddressInterface;
}
