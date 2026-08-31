<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface EbayInternationalShippingInterface
{
    public function getReturnsManagedBy(): ?string;

    public function setReturnsManagedBy(?string $value): self;
}
