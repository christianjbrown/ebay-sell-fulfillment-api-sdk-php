<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ShippingFulfillmentDetails implements ShippingFulfillmentDetailsInterface
{
    /**
     * @var array<int, LineItemReferenceInterface>
     */
    private array $lineItems = [];
    private ?string $shippedDate = null;
    private ?string $shippingCarrierCode = null;
    private ?string $trackingNumber = null;

    /**
     * @return array<int, LineItemReferenceInterface>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    public function getShippedDate(): ?string
    {
        return $this->shippedDate;
    }

    public function getShippingCarrierCode(): ?string
    {
        return $this->shippingCarrierCode;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    /**
     * @param array<int, LineItemReferenceInterface> $value
     */
    public function setLineItems(array $value): ShippingFulfillmentDetailsInterface
    {
        $this->lineItems = $value;

        return $this;
    }

    public function setShippedDate(?string $value): ShippingFulfillmentDetailsInterface
    {
        $this->shippedDate = $value;

        return $this;
    }

    public function setShippingCarrierCode(?string $value): ShippingFulfillmentDetailsInterface
    {
        $this->shippingCarrierCode = $value;

        return $this;
    }

    public function setTrackingNumber(?string $value): ShippingFulfillmentDetailsInterface
    {
        $this->trackingNumber = $value;

        return $this;
    }
}
