<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class NameValuePair implements NameValuePairInterface
{
    private ?string $name = null;
    private ?string $value = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setName(?string $value): NameValuePairInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setValue(?string $value): NameValuePairInterface
    {
        $this->value = $value;

        return $this;
    }
}
