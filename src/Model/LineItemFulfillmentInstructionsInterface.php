<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface LineItemFulfillmentInstructionsInterface
{
    public function getGuaranteedDelivery(): ?bool;

    public function getMaxEstimatedDeliveryDate(): ?string;

    public function getMinEstimatedDeliveryDate(): ?string;

    public function getShipByDate(): ?string;

    public function setGuaranteedDelivery(?bool $value): self;

    public function setMaxEstimatedDeliveryDate(?string $value): self;

    public function setMinEstimatedDeliveryDate(?string $value): self;

    public function setShipByDate(?string $value): self;
}
