<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemPropertiesInterface;

interface LineItemPropertiesTransformerInterface
{
    public const string KEY_BUYER_PROTECTION = 'buyerProtection';
    public const string KEY_FROM_BEST_OFFER = 'fromBestOffer';
    public const string KEY_SOLD_VIA_AD_CAMPAIGN = 'soldViaAdCampaign';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemPropertiesInterface;
}
