<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemFulfillmentInstructionsInterface;

interface LineItemFulfillmentInstructionsTransformerInterface
{
    public const string KEY_DESTINATION_TIME_ZONE = 'destinationTimeZone';
    public const string KEY_GUARANTEED_DELIVERY = 'guaranteedDelivery';
    public const string KEY_MAX_ESTIMATED_DELIVERY_DATE = 'maxEstimatedDeliveryDate';
    public const string KEY_MIN_ESTIMATED_DELIVERY_DATE = 'minEstimatedDeliveryDate';
    public const string KEY_SHIP_BY_DATE = 'shipByDate';
    public const string KEY_SOURCE_TIME_ZONE = 'sourceTimeZone';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemFulfillmentInstructionsInterface;
}
