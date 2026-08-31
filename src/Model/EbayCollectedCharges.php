<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EbayCollectedCharges implements EbayCollectedChargesInterface
{
    private ?AmountInterface $ebayShipping = null;

    public function getEbayShipping(): ?AmountInterface
    {
        return $this->ebayShipping;
    }

    public function setEbayShipping(?AmountInterface $value): EbayCollectedChargesInterface
    {
        $this->ebayShipping = $value;

        return $this;
    }
}
