<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;

interface AppliedPromotionTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_DISCOUNT_AMOUNT = 'discountAmount';
    public const string KEY_PROMOTION_ID = 'promotionId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppliedPromotionInterface;
}
