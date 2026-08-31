<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ExtendedContactInterface
{
    public function getCompanyName(): ?string;

    public function getContactAddress(): ?AddressInterface;

    public function getEmail(): ?string;

    public function getFullName(): ?string;

    public function getPrimaryPhone(): ?PhoneNumberInterface;

    public function setCompanyName(?string $value): self;

    public function setContactAddress(?AddressInterface $value): self;

    public function setEmail(?string $value): self;

    public function setFullName(?string $value): self;

    public function setPrimaryPhone(?PhoneNumberInterface $value): self;
}
