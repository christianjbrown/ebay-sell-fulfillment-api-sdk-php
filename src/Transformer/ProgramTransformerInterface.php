<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ProgramInterface;

interface ProgramTransformerInterface
{
    public const string KEY_AUTHENTICITY_VERIFICATION = 'authenticityVerification';
    public const string KEY_EBAY_INTERNATIONAL_SHIPPING = 'ebayInternationalShipping';
    public const string KEY_EBAY_SHIPPING = 'ebayShipping';
    public const string KEY_EBAY_VAULT = 'ebayVault';
    public const string KEY_FULFILLMENT_PROGRAM = 'fulfillmentProgram';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProgramInterface;
}
