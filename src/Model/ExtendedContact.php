<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ExtendedContact implements ExtendedContactInterface
{
    private ?string $companyName = null;
    private ?AddressInterface $contactAddress = null;
    private ?string $email = null;
    private ?string $fullName = null;
    private ?PhoneNumberInterface $primaryPhone = null;

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getContactAddress(): ?AddressInterface
    {
        return $this->contactAddress;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getPrimaryPhone(): ?PhoneNumberInterface
    {
        return $this->primaryPhone;
    }

    public function setCompanyName(?string $value): ExtendedContactInterface
    {
        $this->companyName = $value;

        return $this;
    }

    public function setContactAddress(?AddressInterface $value): ExtendedContactInterface
    {
        $this->contactAddress = $value;

        return $this;
    }

    public function setEmail(?string $value): ExtendedContactInterface
    {
        $this->email = $value;

        return $this;
    }

    public function setFullName(?string $value): ExtendedContactInterface
    {
        $this->fullName = $value;

        return $this;
    }

    public function setPrimaryPhone(?PhoneNumberInterface $value): ExtendedContactInterface
    {
        $this->primaryPhone = $value;

        return $this;
    }
}
