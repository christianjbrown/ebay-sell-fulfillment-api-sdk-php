<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayInternationalShipping;
use ChristianBrown\EBay\SellFulfillment\Model\EbayInternationalShippingInterface;

use function is_string;

final class EbayInternationalShippingTransformer implements EbayInternationalShippingTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayInternationalShippingInterface
    {
        $ebayInternationalShipping = new EbayInternationalShipping();

        self::applyReturnsManagedBy($ebayInternationalShipping, $data);

        return $ebayInternationalShipping;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReturnsManagedBy(EbayInternationalShipping $ebayInternationalShipping, array $data): void
    {
        if (empty($data[self::KEY_RETURNS_MANAGED_BY])) {
            return;
        }
        if (!is_string($data[self::KEY_RETURNS_MANAGED_BY])) {
            return;
        }
        $ebayInternationalShipping->setReturnsManagedBy($data[self::KEY_RETURNS_MANAGED_BY]);
    }
}
