<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface DisputeSummaryResponseInterface
{
    public function getHref(): ?string;

    public function getLimit(): ?int;

    public function getNext(): ?string;

    public function getOffset(): ?int;

    /**
     * @return array<int, PaymentDisputeSummaryInterface>
     */
    public function getPaymentDisputeSummaries(): array;

    public function getPrev(): ?string;

    public function getTotal(): ?int;

    public function setHref(?string $value): self;

    public function setLimit(?int $value): self;

    public function setNext(?string $value): self;

    public function setOffset(?int $value): self;

    /**
     * @param array<int, PaymentDisputeSummaryInterface> $value
     */
    public function setPaymentDisputeSummaries(array $value): self;

    public function setPrev(?string $value): self;

    public function setTotal(?int $value): self;
}
