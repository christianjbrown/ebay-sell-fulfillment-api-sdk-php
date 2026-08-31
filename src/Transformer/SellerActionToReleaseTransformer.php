<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToRelease;
use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToReleaseInterface;

use function is_string;

final class SellerActionToReleaseTransformer implements SellerActionToReleaseTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerActionToReleaseInterface
    {
        $sellerActionToRelease = new SellerActionToRelease();

        self::applySellerActionToRelease($sellerActionToRelease, $data);

        return $sellerActionToRelease;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySellerActionToRelease(SellerActionToRelease $sellerActionToRelease, array $data): void
    {
        if (empty($data[self::KEY_SELLER_ACTION_TO_RELEASE])) {
            return;
        }
        if (!is_string($data[self::KEY_SELLER_ACTION_TO_RELEASE])) {
            return;
        }
        $sellerActionToRelease->setSellerActionToRelease($data[self::KEY_SELLER_ACTION_TO_RELEASE]);
    }
}
