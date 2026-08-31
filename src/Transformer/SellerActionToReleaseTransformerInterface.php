<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToReleaseInterface;

interface SellerActionToReleaseTransformerInterface
{
    public const string KEY_SELLER_ACTION_TO_RELEASE = 'sellerActionToRelease';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SellerActionToReleaseInterface;
}
