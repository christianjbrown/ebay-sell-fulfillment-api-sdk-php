<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotion;
use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;

use function is_array;
use function is_string;

final class AppliedPromotionTransformer implements AppliedPromotionTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppliedPromotionInterface
    {
        $appliedPromotion = new AppliedPromotion();

        self::applyDescription($appliedPromotion, $data);
        $this->applyDiscountAmount($appliedPromotion, $data);
        self::applyPromotionId($appliedPromotion, $data);

        return $appliedPromotion;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(AppliedPromotion $appliedPromotion, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $appliedPromotion->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDiscountAmount(AppliedPromotion $appliedPromotion, array $data): void
    {
        if (empty($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        $appliedPromotion->setDiscountAmount($this->amountTransformer->transform($data[self::KEY_DISCOUNT_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPromotionId(AppliedPromotion $appliedPromotion, array $data): void
    {
        if (empty($data[self::KEY_PROMOTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PROMOTION_ID])) {
            return;
        }
        $appliedPromotion->setPromotionId($data[self::KEY_PROMOTION_ID]);
    }
}
