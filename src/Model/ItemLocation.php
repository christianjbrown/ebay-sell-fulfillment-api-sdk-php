<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ItemLocation implements ItemLocationInterface
{
    private ?string $countryCode = null;
    private ?string $location = null;
    private ?string $postalCode = null;

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setCountryCode(?string $value): ItemLocationInterface
    {
        $this->countryCode = $value;

        return $this;
    }

    public function setLocation(?string $value): ItemLocationInterface
    {
        $this->location = $value;

        return $this;
    }

    public function setPostalCode(?string $value): ItemLocationInterface
    {
        $this->postalCode = $value;

        return $this;
    }
}
