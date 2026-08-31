<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ExtendedContactInterface;

interface ExtendedContactTransformerInterface
{
    public const string KEY_COMPANY_NAME = 'companyName';
    public const string KEY_CONTACT_ADDRESS = 'contactAddress';
    public const string KEY_EMAIL = 'email';
    public const string KEY_FULL_NAME = 'fullName';
    public const string KEY_PRIMARY_PHONE = 'primaryPhone';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExtendedContactInterface;
}
