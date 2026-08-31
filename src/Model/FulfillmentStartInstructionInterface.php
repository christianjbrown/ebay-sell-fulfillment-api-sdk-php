<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface FulfillmentStartInstructionInterface
{
    public function getEbaySupportedFulfillment(): ?bool;

    public function getFinalDestinationAddress(): ?AddressInterface;

    public function getFulfillmentInstructionsType(): ?string;

    public function getMaxEstimatedDeliveryDate(): ?string;

    public function getMinEstimatedDeliveryDate(): ?string;

    public function getPickupStep(): ?PickupStepInterface;

    public function getShippingStep(): ?ShippingStepInterface;

    public function setEbaySupportedFulfillment(?bool $value): self;

    public function setFinalDestinationAddress(?AddressInterface $value): self;

    public function setFulfillmentInstructionsType(?string $value): self;

    public function setMaxEstimatedDeliveryDate(?string $value): self;

    public function setMinEstimatedDeliveryDate(?string $value): self;

    public function setPickupStep(?PickupStepInterface $value): self;

    public function setShippingStep(?ShippingStepInterface $value): self;
}
