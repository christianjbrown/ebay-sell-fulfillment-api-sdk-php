<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneInterface;

interface PhoneSerializerInterface
{
    public const string KEY_COUNTRY_CODE = 'countryCode';
    public const string KEY_NUMBER = 'number';

    /**
     * @return array<string, mixed>
     */
    public function serialize(PhoneInterface $phone): array;
}
