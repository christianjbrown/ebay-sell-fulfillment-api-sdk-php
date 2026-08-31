<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstruction;
use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstructionInterface;

use function is_array;
use function is_bool;
use function is_string;

final class FulfillmentStartInstructionTransformer implements FulfillmentStartInstructionTransformerInterface
{
    private AddressTransformerInterface $addressTransformer;
    private PickupStepTransformerInterface $pickupStepTransformer;
    private ShippingStepTransformerInterface $shippingStepTransformer;

    public function __construct(AddressTransformerInterface $addressTransformer, PickupStepTransformerInterface $pickupStepTransformer, ShippingStepTransformerInterface $shippingStepTransformer)
    {
        $this->addressTransformer = $addressTransformer;
        $this->pickupStepTransformer = $pickupStepTransformer;
        $this->shippingStepTransformer = $shippingStepTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): FulfillmentStartInstructionInterface
    {
        $fulfillmentStartInstruction = new FulfillmentStartInstruction();

        self::applyEbaySupportedFulfillment($fulfillmentStartInstruction, $data);
        $this->applyFinalDestinationAddress($fulfillmentStartInstruction, $data);
        self::applyFulfillmentInstructionsType($fulfillmentStartInstruction, $data);
        self::applyMaxEstimatedDeliveryDate($fulfillmentStartInstruction, $data);
        self::applyMinEstimatedDeliveryDate($fulfillmentStartInstruction, $data);
        $this->applyPickupStep($fulfillmentStartInstruction, $data);
        $this->applyShippingStep($fulfillmentStartInstruction, $data);

        return $fulfillmentStartInstruction;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEbaySupportedFulfillment(FulfillmentStartInstruction $fulfillmentStartInstruction, array $data): void
    {
        if (!isset($data[self::KEY_EBAY_SUPPORTED_FULFILLMENT])) {
            return;
        }
        if (!is_bool($data[self::KEY_EBAY_SUPPORTED_FULFILLMENT])) {
            return;
        }
        $fulfillmentStartInstruction->setEbaySupportedFulfillment($data[self::KEY_EBAY_SUPPORTED_FULFILLMENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFinalDestinationAddress(FulfillmentStartInstruction $fulfillmentStartInstruction, array $data): void
    {
        if (empty($data[self::KEY_FINAL_DESTINATION_ADDRESS])) {
            return;
        }
        if (!is_array($data[self::KEY_FINAL_DESTINATION_ADDRESS])) {
            return;
        }
        $fulfillmentStartInstruction->setFinalDestinationAddress($this->addressTransformer->transform($data[self::KEY_FINAL_DESTINATION_ADDRESS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFulfillmentInstructionsType(FulfillmentStartInstruction $fulfillmentStartInstruction, array $data): void
    {
        if (empty($data[self::KEY_FULFILLMENT_INSTRUCTIONS_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_FULFILLMENT_INSTRUCTIONS_TYPE])) {
            return;
        }
        $fulfillmentStartInstruction->setFulfillmentInstructionsType($data[self::KEY_FULFILLMENT_INSTRUCTIONS_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaxEstimatedDeliveryDate(FulfillmentStartInstruction $fulfillmentStartInstruction, array $data): void
    {
        if (empty($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $fulfillmentStartInstruction->setMaxEstimatedDeliveryDate($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMinEstimatedDeliveryDate(FulfillmentStartInstruction $fulfillmentStartInstruction, array $data): void
    {
        if (empty($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $fulfillmentStartInstruction->setMinEstimatedDeliveryDate($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPickupStep(FulfillmentStartInstruction $fulfillmentStartInstruction, array $data): void
    {
        if (empty($data[self::KEY_PICKUP_STEP])) {
            return;
        }
        if (!is_array($data[self::KEY_PICKUP_STEP])) {
            return;
        }
        $fulfillmentStartInstruction->setPickupStep($this->pickupStepTransformer->transform($data[self::KEY_PICKUP_STEP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShippingStep(FulfillmentStartInstruction $fulfillmentStartInstruction, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_STEP])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPPING_STEP])) {
            return;
        }
        $fulfillmentStartInstruction->setShippingStep($this->shippingStepTransformer->transform($data[self::KEY_SHIPPING_STEP]));
    }
}
