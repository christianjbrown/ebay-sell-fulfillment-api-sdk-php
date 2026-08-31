<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemProperties;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemPropertiesInterface;

use function is_bool;

final class LineItemPropertiesTransformer implements LineItemPropertiesTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemPropertiesInterface
    {
        $lineItemProperties = new LineItemProperties();

        self::applyBuyerProtection($lineItemProperties, $data);
        self::applyFromBestOffer($lineItemProperties, $data);
        self::applySoldViaAdCampaign($lineItemProperties, $data);

        return $lineItemProperties;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBuyerProtection(LineItemProperties $lineItemProperties, array $data): void
    {
        if (!isset($data[self::KEY_BUYER_PROTECTION])) {
            return;
        }
        if (!is_bool($data[self::KEY_BUYER_PROTECTION])) {
            return;
        }
        $lineItemProperties->setBuyerProtection($data[self::KEY_BUYER_PROTECTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFromBestOffer(LineItemProperties $lineItemProperties, array $data): void
    {
        if (!isset($data[self::KEY_FROM_BEST_OFFER])) {
            return;
        }
        if (!is_bool($data[self::KEY_FROM_BEST_OFFER])) {
            return;
        }
        $lineItemProperties->setFromBestOffer($data[self::KEY_FROM_BEST_OFFER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySoldViaAdCampaign(LineItemProperties $lineItemProperties, array $data): void
    {
        if (!isset($data[self::KEY_SOLD_VIA_AD_CAMPAIGN])) {
            return;
        }
        if (!is_bool($data[self::KEY_SOLD_VIA_AD_CAMPAIGN])) {
            return;
        }
        $lineItemProperties->setSoldViaAdCampaign($data[self::KEY_SOLD_VIA_AD_CAMPAIGN]);
    }
}
