<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class LineItemProperties implements LineItemPropertiesInterface
{
    private ?bool $buyerProtection = null;
    private ?bool $fromBestOffer = null;
    private ?bool $soldViaAdCampaign = null;

    public function getBuyerProtection(): ?bool
    {
        return $this->buyerProtection;
    }

    public function getFromBestOffer(): ?bool
    {
        return $this->fromBestOffer;
    }

    public function getSoldViaAdCampaign(): ?bool
    {
        return $this->soldViaAdCampaign;
    }

    public function setBuyerProtection(?bool $value): LineItemPropertiesInterface
    {
        $this->buyerProtection = $value;

        return $this;
    }

    public function setFromBestOffer(?bool $value): LineItemPropertiesInterface
    {
        $this->fromBestOffer = $value;

        return $this;
    }

    public function setSoldViaAdCampaign(?bool $value): LineItemPropertiesInterface
    {
        $this->soldViaAdCampaign = $value;

        return $this;
    }
}
