<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PricingSummaryInterface
{
    public function getAdjustment(): ?AmountInterface;

    public function getDeliveryCost(): ?AmountInterface;

    public function getDeliveryDiscount(): ?AmountInterface;

    public function getFee(): ?AmountInterface;

    public function getPriceDiscount(): ?AmountInterface;

    public function getPriceSubtotal(): ?AmountInterface;

    public function getTax(): ?AmountInterface;

    public function getTotal(): ?AmountInterface;

    public function setAdjustment(?AmountInterface $value): self;

    public function setDeliveryCost(?AmountInterface $value): self;

    public function setDeliveryDiscount(?AmountInterface $value): self;

    public function setFee(?AmountInterface $value): self;

    public function setPriceDiscount(?AmountInterface $value): self;

    public function setPriceSubtotal(?AmountInterface $value): self;

    public function setTax(?AmountInterface $value): self;

    public function setTotal(?AmountInterface $value): self;
}
