<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EbayShipping implements EbayShippingInterface
{
    private ?string $shippingLabelProvidedBy = null;

    public function getShippingLabelProvidedBy(): ?string
    {
        return $this->shippingLabelProvidedBy;
    }

    public function setShippingLabelProvidedBy(?string $value): EbayShippingInterface
    {
        $this->shippingLabelProvidedBy = $value;

        return $this;
    }
}
