<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface BuyerInterface
{
    public function getBuyerRegistrationAddress(): ?ExtendedContactInterface;

    public function getTaxAddress(): ?TaxAddressInterface;

    public function getTaxIdentifier(): ?TaxIdentifierInterface;

    public function getUsername(): ?string;

    public function setBuyerRegistrationAddress(?ExtendedContactInterface $value): self;

    public function setTaxAddress(?TaxAddressInterface $value): self;

    public function setTaxIdentifier(?TaxIdentifierInterface $value): self;

    public function setUsername(?string $value): self;
}
