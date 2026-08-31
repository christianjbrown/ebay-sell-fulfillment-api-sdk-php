<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneInterface;

interface PhoneTransformerInterface
{
    public const string KEY_COUNTRY_CODE = 'countryCode';
    public const string KEY_NUMBER = 'number';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PhoneInterface;
}
