<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class FulfillmentStartInstruction implements FulfillmentStartInstructionInterface
{
    private ?bool $ebaySupportedFulfillment = null;
    private ?AddressInterface $finalDestinationAddress = null;
    private ?string $fulfillmentInstructionsType = null;
    private ?string $maxEstimatedDeliveryDate = null;
    private ?string $minEstimatedDeliveryDate = null;
    private ?PickupStepInterface $pickupStep = null;
    private ?ShippingStepInterface $shippingStep = null;

    public function getEbaySupportedFulfillment(): ?bool
    {
        return $this->ebaySupportedFulfillment;
    }

    public function getFinalDestinationAddress(): ?AddressInterface
    {
        return $this->finalDestinationAddress;
    }

    public function getFulfillmentInstructionsType(): ?string
    {
        return $this->fulfillmentInstructionsType;
    }

    public function getMaxEstimatedDeliveryDate(): ?string
    {
        return $this->maxEstimatedDeliveryDate;
    }

    public function getMinEstimatedDeliveryDate(): ?string
    {
        return $this->minEstimatedDeliveryDate;
    }

    public function getPickupStep(): ?PickupStepInterface
    {
        return $this->pickupStep;
    }

    public function getShippingStep(): ?ShippingStepInterface
    {
        return $this->shippingStep;
    }

    public function setEbaySupportedFulfillment(?bool $value): FulfillmentStartInstructionInterface
    {
        $this->ebaySupportedFulfillment = $value;

        return $this;
    }

    public function setFinalDestinationAddress(?AddressInterface $value): FulfillmentStartInstructionInterface
    {
        $this->finalDestinationAddress = $value;

        return $this;
    }

    public function setFulfillmentInstructionsType(?string $value): FulfillmentStartInstructionInterface
    {
        $this->fulfillmentInstructionsType = $value;

        return $this;
    }

    public function setMaxEstimatedDeliveryDate(?string $value): FulfillmentStartInstructionInterface
    {
        $this->maxEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setMinEstimatedDeliveryDate(?string $value): FulfillmentStartInstructionInterface
    {
        $this->minEstimatedDeliveryDate = $value;

        return $this;
    }

    public function setPickupStep(?PickupStepInterface $value): FulfillmentStartInstructionInterface
    {
        $this->pickupStep = $value;

        return $this;
    }

    public function setShippingStep(?ShippingStepInterface $value): FulfillmentStartInstructionInterface
    {
        $this->shippingStep = $value;

        return $this;
    }
}
