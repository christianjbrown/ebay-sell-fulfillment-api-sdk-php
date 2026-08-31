<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class SellerActionToRelease implements SellerActionToReleaseInterface
{
    private ?string $sellerActionToRelease = null;

    public function getSellerActionToRelease(): ?string
    {
        return $this->sellerActionToRelease;
    }

    public function setSellerActionToRelease(?string $value): SellerActionToReleaseInterface
    {
        $this->sellerActionToRelease = $value;

        return $this;
    }
}
