<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EbayCollectedCharges implements EbayCollectedChargesInterface
{
    /**
     * @var array<int, ChargeInterface>
     */
    private array $charges = [];
    private ?AmountInterface $ebayShipping = null;

    /**
     * @return array<int, ChargeInterface>
     */
    public function getCharges(): array
    {
        return $this->charges;
    }

    public function getEbayShipping(): ?AmountInterface
    {
        return $this->ebayShipping;
    }

    /**
     * @param array<int, ChargeInterface> $value
     */
    public function setCharges(array $value): EbayCollectedChargesInterface
    {
        $this->charges = $value;

        return $this;
    }

    public function setEbayShipping(?AmountInterface $value): EbayCollectedChargesInterface
    {
        $this->ebayShipping = $value;

        return $this;
    }
}
