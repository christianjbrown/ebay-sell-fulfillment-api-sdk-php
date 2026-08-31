<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class DisputeSummaryResponse implements DisputeSummaryResponseInterface
{
    private ?string $href = null;
    private ?int $limit = null;
    private ?string $next = null;
    private ?int $offset = null;

    /**
     * @var array<int, PaymentDisputeSummaryInterface>
     */
    private array $paymentDisputeSummaries = [];
    private ?string $prev = null;
    private ?int $total = null;

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
     * @return array<int, PaymentDisputeSummaryInterface>
     */
    public function getPaymentDisputeSummaries(): array
    {
        return $this->paymentDisputeSummaries;
    }

    public function getPrev(): ?string
    {
        return $this->prev;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setHref(?string $value): DisputeSummaryResponseInterface
    {
        $this->href = $value;

        return $this;
    }

    public function setLimit(?int $value): DisputeSummaryResponseInterface
    {
        $this->limit = $value;

        return $this;
    }

    public function setNext(?string $value): DisputeSummaryResponseInterface
    {
        $this->next = $value;

        return $this;
    }

    public function setOffset(?int $value): DisputeSummaryResponseInterface
    {
        $this->offset = $value;

        return $this;
    }

    /**
     * @param array<int, PaymentDisputeSummaryInterface> $value
     */
    public function setPaymentDisputeSummaries(array $value): DisputeSummaryResponseInterface
    {
        $this->paymentDisputeSummaries = $value;

        return $this;
    }

    public function setPrev(?string $value): DisputeSummaryResponseInterface
    {
        $this->prev = $value;

        return $this;
    }

    public function setTotal(?int $value): DisputeSummaryResponseInterface
    {
        $this->total = $value;

        return $this;
    }
}
