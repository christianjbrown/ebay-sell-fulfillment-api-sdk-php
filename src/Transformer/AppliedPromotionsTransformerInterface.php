<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;

interface AppliedPromotionsTransformerInterface
{
    public const string ARRAY_NAME = 'applied_promotion';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, AppliedPromotionInterface>
     */
    public function transform(array $data): array;
}
