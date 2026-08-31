<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstructionInterface;

interface FulfillmentStartInstructionTransformerInterface
{
    public const string KEY_EBAY_SUPPORTED_FULFILLMENT = 'ebaySupportedFulfillment';
    public const string KEY_FINAL_DESTINATION_ADDRESS = 'finalDestinationAddress';
    public const string KEY_FULFILLMENT_INSTRUCTIONS_TYPE = 'fulfillmentInstructionsType';
    public const string KEY_MAX_ESTIMATED_DELIVERY_DATE = 'maxEstimatedDeliveryDate';
    public const string KEY_MIN_ESTIMATED_DELIVERY_DATE = 'minEstimatedDeliveryDate';
    public const string KEY_PICKUP_STEP = 'pickupStep';
    public const string KEY_SHIPPING_STEP = 'shippingStep';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): FulfillmentStartInstructionInterface;
}
