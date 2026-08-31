<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class AppliedPromotion implements AppliedPromotionInterface
{
    private ?string $description = null;
    private ?AmountInterface $discountAmount = null;
    private ?string $promotionId = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDiscountAmount(): ?AmountInterface
    {
        return $this->discountAmount;
    }

    public function getPromotionId(): ?string
    {
        return $this->promotionId;
    }

    public function setDescription(?string $value): AppliedPromotionInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDiscountAmount(?AmountInterface $value): AppliedPromotionInterface
    {
        $this->discountAmount = $value;

        return $this;
    }

    public function setPromotionId(?string $value): AppliedPromotionInterface
    {
        $this->promotionId = $value;

        return $this;
    }
}
