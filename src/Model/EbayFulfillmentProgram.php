<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EbayFulfillmentProgram implements EbayFulfillmentProgramInterface
{
    private ?string $fulfilledBy = null;

    public function getFulfilledBy(): ?string
    {
        return $this->fulfilledBy;
    }

    public function setFulfilledBy(?string $value): EbayFulfillmentProgramInterface
    {
        $this->fulfilledBy = $value;

        return $this;
    }
}
