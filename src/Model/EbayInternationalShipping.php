<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EbayInternationalShipping implements EbayInternationalShippingInterface
{
    private ?string $returnsManagedBy = null;

    public function getReturnsManagedBy(): ?string
    {
        return $this->returnsManagedBy;
    }

    public function setReturnsManagedBy(?string $value): EbayInternationalShippingInterface
    {
        $this->returnsManagedBy = $value;

        return $this;
    }
}
