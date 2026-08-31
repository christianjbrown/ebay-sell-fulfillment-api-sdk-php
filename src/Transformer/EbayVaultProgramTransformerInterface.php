<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayVaultProgramInterface;

interface EbayVaultProgramTransformerInterface
{
    public const string KEY_FULFILLMENT_TYPE = 'fulfillmentType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayVaultProgramInterface;
}
