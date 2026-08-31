<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ItemLocationInterface;

interface ItemLocationTransformerInterface
{
    public const string KEY_COUNTRY_CODE = 'countryCode';
    public const string KEY_LOCATION = 'location';
    public const string KEY_POSTAL_CODE = 'postalCode';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemLocationInterface;
}
