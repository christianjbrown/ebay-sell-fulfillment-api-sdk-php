<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface DeliveryCostInterface
{
    public function getDiscountAmount(): ?AmountInterface;

    public function getHandlingCost(): ?AmountInterface;

    public function getImportCharges(): ?AmountInterface;

    public function getShippingCost(): ?AmountInterface;

    public function getShippingIntermediationFee(): ?AmountInterface;

    public function setDiscountAmount(?AmountInterface $value): self;

    public function setHandlingCost(?AmountInterface $value): self;

    public function setImportCharges(?AmountInterface $value): self;

    public function setShippingCost(?AmountInterface $value): self;

    public function setShippingIntermediationFee(?AmountInterface $value): self;
}
