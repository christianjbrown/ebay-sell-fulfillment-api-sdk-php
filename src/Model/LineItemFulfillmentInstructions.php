<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class LineItemFulfillmentInstructions implements LineItemFulfillmentInstructionsInterface
{
    private ?bool $guaranteedDelivery = null;
    private ?string $maxEstimatedDeliveryDate = null;
    private ?string $minEstimatedDeliveryDate = null;
    private ?string $shipByDate = null;

    public function getGuaranteedDelivery(): ?bool
    {
        return $this->guaranteedDelivery;
    }

    public function getMaxEstimatedDeliveryDate(): ?string
    {
        return $this->maxEstimatedDeliveryDate;
    }

    public function getMinEstimatedDeliveryDate(): ?string
    {
        return $this->minEstimatedDeliveryDate;
    }

    public function getShipByDate(): ?string
    {
        return $this->shipByDate;
    }

    public function setGuaranteedDelivery(?bool $value): LineItemFulfillmentInstructionsInterface
    {
        $this->guaranteedDelivery = $value;

        return $this;
    }

    public function setMaxEstimatedDeliveryDate(?string $value): LineItemFulfillmentInstructionsInterface
    {
        $this->maxEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setMinEstimatedDeliveryDate(?string $value): LineItemFulfillmentInstructionsInterface
    {
        $this->minEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setShipByDate(?string $value): LineItemFulfillmentInstructionsInterface
    {
        $this->shipByDate = $value;

        return $this;
    }
}
