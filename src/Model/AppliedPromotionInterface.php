<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface AppliedPromotionInterface
{
    public function getDescription(): ?string;

    public function getDiscountAmount(): ?AmountInterface;

    public function getPromotionId(): ?string;

    public function setDescription(?string $value): self;

    public function setDiscountAmount(?AmountInterface $value): self;

    public function setPromotionId(?string $value): self;
}
