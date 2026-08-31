<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface LineItemPropertiesInterface
{
    public function getBuyerProtection(): ?bool;

    public function getFromBestOffer(): ?bool;

    public function getSoldViaAdCampaign(): ?bool;

    public function setBuyerProtection(?bool $value): self;

    public function setFromBestOffer(?bool $value): self;

    public function setSoldViaAdCampaign(?bool $value): self;
}
