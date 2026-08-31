<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Buyer implements BuyerInterface
{
    private ?ExtendedContactInterface $buyerRegistrationAddress = null;
    private ?TaxAddressInterface $taxAddress = null;
    private ?TaxIdentifierInterface $taxIdentifier = null;
    private ?string $username = null;

    public function getBuyerRegistrationAddress(): ?ExtendedContactInterface
    {
        return $this->buyerRegistrationAddress;
    }

    public function getTaxAddress(): ?TaxAddressInterface
    {
        return $this->taxAddress;
    }

    public function getTaxIdentifier(): ?TaxIdentifierInterface
    {
        return $this->taxIdentifier;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setBuyerRegistrationAddress(?ExtendedContactInterface $value): BuyerInterface
    {
        $this->buyerRegistrationAddress = $value;

        return $this;
    }

    public function setTaxAddress(?TaxAddressInterface $value): BuyerInterface
    {
        $this->taxAddress = $value;

        return $this;
    }

    public function setTaxIdentifier(?TaxIdentifierInterface $value): BuyerInterface
    {
        $this->taxIdentifier = $value;

        return $this;
    }

    public function setUsername(?string $value): BuyerInterface
    {
        $this->username = $value;

        return $this;
    }
}
