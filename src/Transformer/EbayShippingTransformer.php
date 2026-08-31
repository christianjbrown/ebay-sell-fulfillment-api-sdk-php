<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayShipping;
use ChristianBrown\EBay\SellFulfillment\Model\EbayShippingInterface;

use function is_string;

final class EbayShippingTransformer implements EbayShippingTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayShippingInterface
    {
        $ebayShipping = new EbayShipping();

        self::applyShippingLabelProvidedBy($ebayShipping, $data);

        return $ebayShipping;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShippingLabelProvidedBy(EbayShipping $ebayShipping, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_LABEL_PROVIDED_BY])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIPPING_LABEL_PROVIDED_BY])) {
            return;
        }
        $ebayShipping->setShippingLabelProvidedBy($data[self::KEY_SHIPPING_LABEL_PROVIDED_BY]);
    }
}
