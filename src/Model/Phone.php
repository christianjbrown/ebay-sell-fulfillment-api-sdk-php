<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Phone implements PhoneInterface
{
    private ?string $countryCode = null;
    private ?string $number = null;

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setCountryCode(?string $value): PhoneInterface
    {
        $this->countryCode = $value;

        return $this;
    }

    public function setNumber(?string $value): PhoneInterface
    {
        $this->number = $value;

        return $this;
    }
}
