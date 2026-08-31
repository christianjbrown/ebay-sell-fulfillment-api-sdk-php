<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface TaxIdentifierInterface
{
    public function getIssuingCountry(): ?string;

    public function getTaxIdentifierType(): ?string;

    public function getTaxpayerId(): ?string;

    public function setIssuingCountry(?string $value): self;

    public function setTaxIdentifierType(?string $value): self;

    public function setTaxpayerId(?string $value): self;
}
