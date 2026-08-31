<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ReturnAddress implements ReturnAddressInterface
{
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $city = null;
    private ?string $country = null;
    private ?string $county = null;
    private ?string $fullName = null;
    private ?string $postalCode = null;
    private ?PhoneInterface $primaryPhone = null;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getPrimaryPhone(): ?PhoneInterface
    {
        return $this->primaryPhone;
    }

    public function getStateOrProvince(): ?string
    {
        return $this->stateOrProvince;
    }

    public function setAddressLine1(?string $value): ReturnAddressInterface
    {
        $this->addressLine1 = $value;

        return $this;
    }

    public function setAddressLine2(?string $value): ReturnAddressInterface
    {
        $this->addressLine2 = $value;

        return $this;
    }

    public function setCity(?string $value): ReturnAddressInterface
    {
        $this->city = $value;

        return $this;
    }

    public function setCountry(?string $value): ReturnAddressInterface
    {
        $this->country = $value;

        return $this;
    }

    public function setCounty(?string $value): ReturnAddressInterface
    {
        $this->county = $value;

        return $this;
    }

    public function setFullName(?string $value): ReturnAddressInterface
    {
        $this->fullName = $value;

        return $this;
    }

    public function setPostalCode(?string $value): ReturnAddressInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setPrimaryPhone(?PhoneInterface $value): ReturnAddressInterface
    {
        $this->primaryPhone = $value;

        return $this;
    }

    public function setStateOrProvince(?string $value): ReturnAddressInterface
    {
        $this->stateOrProvince = $value;

        return $this;
    }
}
