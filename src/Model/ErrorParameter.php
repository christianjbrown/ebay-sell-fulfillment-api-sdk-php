<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class ErrorParameter implements ErrorParameterInterface
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

    public function setName(?string $value): ErrorParameterInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setValue(?string $value): ErrorParameterInterface
    {
        $this->value = $value;

        return $this;
    }
}
