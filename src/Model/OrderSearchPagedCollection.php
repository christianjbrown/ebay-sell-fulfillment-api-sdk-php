<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class OrderSearchPagedCollection implements OrderSearchPagedCollectionInterface
{
    private ?string $href = null;
    private ?int $limit = null;
    private ?string $next = null;
    private ?int $offset = null;

    /**
     * @var array<int, OrderInterface>
     */
    private array $orders = [];
    private ?string $prev = null;
    private ?int $total = null;

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return array<int, OrderInterface>
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    public function getPrev(): ?string
    {
        return $this->prev;
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

    public function setHref(?string $value): OrderSearchPagedCollectionInterface
    {
        $this->href = $value;

        return $this;
    }

    public function setLimit(?int $value): OrderSearchPagedCollectionInterface
    {
        $this->limit = $value;

        return $this;
    }

    public function setNext(?string $value): OrderSearchPagedCollectionInterface
    {
        $this->next = $value;

        return $this;
    }

    public function setOffset(?int $value): OrderSearchPagedCollectionInterface
    {
        $this->offset = $value;

        return $this;
    }

    /**
     * @param array<int, OrderInterface> $value
     */
    public function setOrders(array $value): OrderSearchPagedCollectionInterface
    {
        $this->orders = $value;

        return $this;
    }

    public function setPrev(?string $value): OrderSearchPagedCollectionInterface
    {
        $this->prev = $value;

        return $this;
    }

    public function setTotal(?int $value): OrderSearchPagedCollectionInterface
    {
        $this->total = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): OrderSearchPagedCollectionInterface
    {
        $this->warnings = $value;

        return $this;
    }
}
