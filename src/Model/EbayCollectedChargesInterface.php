<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface EbayCollectedChargesInterface
{
    /**
     * @return array<int, ChargeInterface>
     */
    public function getCharges(): array;

    public function getEbayShipping(): ?AmountInterface;

    /**
     * @param array<int, ChargeInterface> $value
     */
    public function setCharges(array $value): self;

    public function setEbayShipping(?AmountInterface $value): self;
}
