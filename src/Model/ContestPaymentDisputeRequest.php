<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ContestPaymentDisputeRequest implements ContestPaymentDisputeRequestInterface
{
    private ?string $note = null;
    private ?ReturnAddressInterface $returnAddress = null;
    private ?int $revision = null;

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function getReturnAddress(): ?ReturnAddressInterface
    {
        return $this->returnAddress;
    }

    public function getRevision(): ?int
    {
        return $this->revision;
    }

    public function setNote(?string $value): ContestPaymentDisputeRequestInterface
    {
        $this->note = $value;

        return $this;
    }

    public function setReturnAddress(?ReturnAddressInterface $value): ContestPaymentDisputeRequestInterface
    {
        $this->returnAddress = $value;

        return $this;
    }

    public function setRevision(?int $value): ContestPaymentDisputeRequestInterface
    {
        $this->revision = $value;

        return $this;
    }
}
