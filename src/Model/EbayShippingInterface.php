<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface EbayShippingInterface
{
    public function getShippingLabelProvidedBy(): ?string;

    public function setShippingLabelProvidedBy(?string $value): self;
}
