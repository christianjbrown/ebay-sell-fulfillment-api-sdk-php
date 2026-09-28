<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Property implements PropertyInterface
{
    private ?string $propertyDisplayName = null;
    private ?string $propertyName = null;
    private ?string $propertyValue = null;

    public function getPropertyDisplayName(): ?string
    {
        return $this->propertyDisplayName;
    }

    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    public function getPropertyValue(): ?string
    {
        return $this->propertyValue;
    }

    public function setPropertyDisplayName(?string $value): PropertyInterface
    {
        $this->propertyDisplayName = $value;

        return $this;
    }

    public function setPropertyName(?string $value): PropertyInterface
    {
        $this->propertyName = $value;

        return $this;
    }

    public function setPropertyValue(?string $value): PropertyInterface
    {
        $this->propertyValue = $value;

        return $this;
    }
}
