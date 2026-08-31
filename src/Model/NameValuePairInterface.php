<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface NameValuePairInterface
{
    public function getName(): ?string;

    public function getValue(): ?string;

    public function setName(?string $value): self;

    public function setValue(?string $value): self;
}
