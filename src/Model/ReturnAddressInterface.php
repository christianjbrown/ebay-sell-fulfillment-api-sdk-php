<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ReturnAddressInterface
{
    public function getAddressLine1(): ?string;

    public function getAddressLine2(): ?string;

    public function getCity(): ?string;

    public function getCountry(): ?string;

    public function getCounty(): ?string;

    public function getFullName(): ?string;

    public function getPostalCode(): ?string;

    public function getPrimaryPhone(): ?PhoneInterface;

    public function getStateOrProvince(): ?string;

    public function setAddressLine1(?string $value): self;

    public function setAddressLine2(?string $value): self;

    public function setCity(?string $value): self;

    public function setCountry(?string $value): self;

    public function setCounty(?string $value): self;

    public function setFullName(?string $value): self;

    public function setPostalCode(?string $value): self;

    public function setPrimaryPhone(?PhoneInterface $value): self;

    public function setStateOrProvince(?string $value): self;
}
