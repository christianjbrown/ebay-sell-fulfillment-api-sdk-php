<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EbayVaultProgram implements EbayVaultProgramInterface
{
    private ?string $fulfillmentType = null;

    public function getFulfillmentType(): ?string
    {
        return $this->fulfillmentType;
    }

    public function setFulfillmentType(?string $value): EbayVaultProgramInterface
    {
        $this->fulfillmentType = $value;

        return $this;
    }
}
