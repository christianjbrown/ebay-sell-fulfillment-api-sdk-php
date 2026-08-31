<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface OrderSearchPagedCollectionInterface
{
    public function getHref(): ?string;

    public function getLimit(): ?int;

    public function getNext(): ?string;

    public function getOffset(): ?int;

    /**
     * @return array<int, OrderInterface>
     */
    public function getOrders(): array;

    public function getPrev(): ?string;

    public function getTotal(): ?int;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    public function setHref(?string $value): self;

    public function setLimit(?int $value): self;

    public function setNext(?string $value): self;

    public function setOffset(?int $value): self;

    /**
     * @param array<int, OrderInterface> $value
     */
    public function setOrders(array $value): self;

    public function setPrev(?string $value): self;

    public function setTotal(?int $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;
}
