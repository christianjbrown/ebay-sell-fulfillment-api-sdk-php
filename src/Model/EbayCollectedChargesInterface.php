<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface EbayCollectedChargesInterface
{
    public function getEbayShipping(): ?AmountInterface;

    public function setEbayShipping(?AmountInterface $value): self;
}
