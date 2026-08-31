<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class AcceptPaymentDisputeRequest implements AcceptPaymentDisputeRequestInterface
{
    private ?ReturnAddressInterface $returnAddress = null;
    private ?int $revision = null;

    public function getReturnAddress(): ?ReturnAddressInterface
    {
        return $this->returnAddress;
    }

    public function getRevision(): ?int
    {
        return $this->revision;
    }

    public function setReturnAddress(?ReturnAddressInterface $value): AcceptPaymentDisputeRequestInterface
    {
        $this->returnAddress = $value;

        return $this;
    }

    public function setRevision(?int $value): AcceptPaymentDisputeRequestInterface
    {
        $this->revision = $value;

        return $this;
    }
}
