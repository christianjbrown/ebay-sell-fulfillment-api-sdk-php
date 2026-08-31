<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneNumberInterface;

interface PhoneNumberTransformerInterface
{
    public const string KEY_PHONE_NUMBER = 'phoneNumber';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PhoneNumberInterface;
}
