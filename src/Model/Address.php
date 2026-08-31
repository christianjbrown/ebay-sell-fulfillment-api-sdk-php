<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Address implements AddressInterface
{
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $city = null;
    private ?string $countryCode = null;
    private ?string $county = null;
    private ?string $postalCode = null;
    private ?string $stateOrProvince = null;

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getStateOrProvince(): ?string
    {
        return $this->stateOrProvince;
    }

    public function setAddressLine1(?string $value): AddressInterface
    {
        $this->addressLine1 = $value;

        return $this;
    }

    public function setAddressLine2(?string $value): AddressInterface
    {
        $this->addressLine2 = $value;

        return $this;
    }

    public function setCity(?string $value): AddressInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setCountryCode(?string $value): AddressInterface
    {
        $this->countryCode = $value;

        return $this;
    }

    public function setCounty(?string $value): AddressInterface
    {
        $this->county = $value;

        return $this;
    }

    public function setPostalCode(?string $value): AddressInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setStateOrProvince(?string $value): AddressInterface
    {
        $this->stateOrProvince = $value;

        return $this;
    }
}
