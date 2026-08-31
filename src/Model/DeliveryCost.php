<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class DeliveryCost implements DeliveryCostInterface
{
    private ?AmountInterface $discountAmount = null;
    private ?AmountInterface $handlingCost = null;
    private ?AmountInterface $importCharges = null;
    private ?AmountInterface $shippingCost = null;
    private ?AmountInterface $shippingIntermediationFee = null;

    public function getDiscountAmount(): ?AmountInterface
    {
        return $this->discountAmount;
    }

    public function getHandlingCost(): ?AmountInterface
    {
        return $this->handlingCost;
    }

    public function getImportCharges(): ?AmountInterface
    {
        return $this->importCharges;
    }

    public function getShippingCost(): ?AmountInterface
    {
        return $this->shippingCost;
    }

    public function getShippingIntermediationFee(): ?AmountInterface
    {
        return $this->shippingIntermediationFee;
    }

    public function setDiscountAmount(?AmountInterface $value): DeliveryCostInterface
    {
        $this->discountAmount = $value;

        return $this;
    }

    public function setHandlingCost(?AmountInterface $value): DeliveryCostInterface
    {
        $this->handlingCost = $value;

        return $this;
    }

    public function setImportCharges(?AmountInterface $value): DeliveryCostInterface
    {
        $this->importCharges = $value;

        return $this;
    }

    public function setShippingCost(?AmountInterface $value): DeliveryCostInterface
    {
        $this->shippingCost = $value;

        return $this;
    }

    public function setShippingIntermediationFee(?AmountInterface $value): DeliveryCostInterface
    {
        $this->shippingIntermediationFee = $value;

        return $this;
    }
}
