<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PropertyInterface
{
    public function getPropertyDisplayName(): ?string;

    public function getPropertyName(): ?string;

    public function getPropertyValue(): ?string;

    public function setPropertyDisplayName(?string $value): self;

    public function setPropertyName(?string $value): self;

    public function setPropertyValue(?string $value): self;
}
