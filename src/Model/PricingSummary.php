<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PricingSummary implements PricingSummaryInterface
{
    private ?AmountInterface $adjustment = null;
    private ?AmountInterface $deliveryCost = null;
    private ?AmountInterface $deliveryDiscount = null;
    private ?AmountInterface $fee = null;
    private ?AmountInterface $priceDiscount = null;
    private ?AmountInterface $priceSubtotal = null;
    private ?AmountInterface $tax = null;
    private ?AmountInterface $total = null;

    public function getAdjustment(): ?AmountInterface
    {
        return $this->adjustment;
    }

    public function getDeliveryCost(): ?AmountInterface
    {
        return $this->deliveryCost;
    }

    public function getDeliveryDiscount(): ?AmountInterface
    {
        return $this->deliveryDiscount;
    }

    public function getFee(): ?AmountInterface
    {
        return $this->fee;
    }

    public function getPriceDiscount(): ?AmountInterface
    {
        return $this->priceDiscount;
    }

    public function getPriceSubtotal(): ?AmountInterface
    {
        return $this->priceSubtotal;
    }

    public function getTax(): ?AmountInterface
    {
        return $this->tax;
    }

    public function getTotal(): ?AmountInterface
    {
        return $this->total;
    }

    public function setAdjustment(?AmountInterface $value): PricingSummaryInterface
    {
        $this->adjustment = $value;

        return $this;
    }

    public function setDeliveryCost(?AmountInterface $value): PricingSummaryInterface
    {
        $this->deliveryCost = $value;

        return $this;
    }

    public function setDeliveryDiscount(?AmountInterface $value): PricingSummaryInterface
    {
        $this->deliveryDiscount = $value;

        return $this;
    }

    public function setFee(?AmountInterface $value): PricingSummaryInterface
    {
        $this->fee = $value;

        return $this;
    }

    public function setPriceDiscount(?AmountInterface $value): PricingSummaryInterface
    {
        $this->priceDiscount = $value;

        return $this;
    }

    public function setPriceSubtotal(?AmountInterface $value): PricingSummaryInterface
    {
        $this->priceSubtotal = $value;

        return $this;
    }

    public function setTax(?AmountInterface $value): PricingSummaryInterface
    {
        $this->tax = $value;

        return $this;
    }

    public function setTotal(?AmountInterface $value): PricingSummaryInterface
    {
        $this->total = $value;

        return $this;
    }
}
