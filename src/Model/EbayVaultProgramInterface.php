<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface EbayVaultProgramInterface
{
    public function getFulfillmentType(): ?string;

    public function setFulfillmentType(?string $value): self;
}
