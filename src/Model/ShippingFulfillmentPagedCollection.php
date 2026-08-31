<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ShippingFulfillmentPagedCollection implements ShippingFulfillmentPagedCollectionInterface
{
    /**
     * @var array<int, ShippingFulfillmentInterface>
     */
    private array $fulfillments = [];
    private ?int $total = null;

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];

    /**
     * @return array<int, ShippingFulfillmentInterface>
     */
    public function getFulfillments(): array
    {
        return $this->fulfillments;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @param array<int, ShippingFulfillmentInterface> $value
     */
    public function setFulfillments(array $value): ShippingFulfillmentPagedCollectionInterface
    {
        $this->fulfillments = $value;

        return $this;
    }

    public function setTotal(?int $value): ShippingFulfillmentPagedCollectionInterface
    {
        $this->total = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): ShippingFulfillmentPagedCollectionInterface
    {
        $this->warnings = $value;

        return $this;
    }
}
