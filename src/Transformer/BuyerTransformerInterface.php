<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\BuyerInterface;

interface BuyerTransformerInterface
{
    public const string KEY_BUYER_REGISTRATION_ADDRESS = 'buyerRegistrationAddress';
    public const string KEY_TAX_ADDRESS = 'taxAddress';
    public const string KEY_TAX_IDENTIFIER = 'taxIdentifier';
    public const string KEY_USERNAME = 'username';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BuyerInterface;
}
