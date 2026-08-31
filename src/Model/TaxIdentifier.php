<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class TaxIdentifier implements TaxIdentifierInterface
{
    private ?string $issuingCountry = null;
    private ?string $taxIdentifierType = null;
    private ?string $taxpayerId = null;

    public function getIssuingCountry(): ?string
    {
        return $this->issuingCountry;
    }

    public function getTaxIdentifierType(): ?string
    {
        return $this->taxIdentifierType;
    }

    public function getTaxpayerId(): ?string
    {
        return $this->taxpayerId;
    }

    public function setIssuingCountry(?string $value): TaxIdentifierInterface
    {
        $this->issuingCountry = $value;

        return $this;
    }

    public function setTaxIdentifierType(?string $value): TaxIdentifierInterface
    {
        $this->taxIdentifierType = $value;

        return $this;
    }

    public function setTaxpayerId(?string $value): TaxIdentifierInterface
    {
        $this->taxpayerId = $value;

        return $this;
    }
}
