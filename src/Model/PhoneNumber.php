<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PhoneNumber implements PhoneNumberInterface
{
    private ?string $phoneNumber = null;

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $value): PhoneNumberInterface
    {
        $this->phoneNumber = $value;

        return $this;
    }
}
