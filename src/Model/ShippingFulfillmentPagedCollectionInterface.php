<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ShippingFulfillmentPagedCollectionInterface
{
    /**
     * @return array<int, ShippingFulfillmentInterface>
     */
    public function getFulfillments(): array;

    public function getTotal(): ?int;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    /**
     * @param array<int, ShippingFulfillmentInterface> $value
     */
    public function setFulfillments(array $value): self;

    public function setTotal(?int $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;
}
