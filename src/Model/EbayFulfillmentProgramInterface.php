<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface EbayFulfillmentProgramInterface
{
    public function getFulfilledBy(): ?string;

    public function setFulfilledBy(?string $value): self;
}
