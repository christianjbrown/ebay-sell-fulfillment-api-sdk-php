<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ShippingFulfillment implements ShippingFulfillmentInterface
{
    private ?string $fulfillmentId = null;

    /**
     * @var array<int, LineItemReferenceInterface>
     */
    private array $lineItems = [];
    private ?string $shipmentTrackingNumber = null;
    private ?string $shippedDate = null;
    private ?string $shippingCarrierCode = null;

    public function getFulfillmentId(): ?string
    {
        return $this->fulfillmentId;
    }

    /**
     * @return array<int, LineItemReferenceInterface>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    public function getShipmentTrackingNumber(): ?string
    {
        return $this->shipmentTrackingNumber;
    }

    public function getShippedDate(): ?string
    {
        return $this->shippedDate;
    }

    public function getShippingCarrierCode(): ?string
    {
        return $this->shippingCarrierCode;
    }

    public function setFulfillmentId(?string $value): ShippingFulfillmentInterface
    {
        $this->fulfillmentId = $value;

        return $this;
    }

    /**
     * @param array<int, LineItemReferenceInterface> $value
     */
    public function setLineItems(array $value): ShippingFulfillmentInterface
    {
        $this->lineItems = $value;

        return $this;
    }

    public function setShipmentTrackingNumber(?string $value): ShippingFulfillmentInterface
    {
        $this->shipmentTrackingNumber = $value;

        return $this;
    }

    public function setShippedDate(?string $value): ShippingFulfillmentInterface
    {
        $this->shippedDate = $value;

        return $this;
    }

    public function setShippingCarrierCode(?string $value): ShippingFulfillmentInterface
    {
        $this->shippingCarrierCode = $value;

        return $this;
    }
}
