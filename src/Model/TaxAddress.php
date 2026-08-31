<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class TaxAddress implements TaxAddressInterface
{
    private ?string $city = null;
    private ?string $countryCode = null;
    private ?string $postalCode = null;
    private ?string $stateOrProvince = null;

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getStateOrProvince(): ?string
    {
        return $this->stateOrProvince;
    }

    public function setCity(?string $value): TaxAddressInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setCountryCode(?string $value): TaxAddressInterface
    {
        $this->countryCode = $value;

        return $this;
    }

    public function setPostalCode(?string $value): TaxAddressInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setStateOrProvince(?string $value): TaxAddressInterface
    {
        $this->stateOrProvince = $value;

        return $this;
    }
}
