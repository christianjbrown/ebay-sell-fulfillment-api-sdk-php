<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface SellerActionToReleaseInterface
{
    public function getSellerActionToRelease(): ?string;

    public function setSellerActionToRelease(?string $value): self;
}
