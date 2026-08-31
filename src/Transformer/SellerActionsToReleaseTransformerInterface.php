<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToReleaseInterface;

interface SellerActionsToReleaseTransformerInterface
{
    public const string ARRAY_NAME = 'seller_action_to_release';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, SellerActionToReleaseInterface>
     */
    public function transform(array $data): array;
}
