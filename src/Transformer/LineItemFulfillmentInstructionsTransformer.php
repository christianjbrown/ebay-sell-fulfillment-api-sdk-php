<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemFulfillmentInstructions;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemFulfillmentInstructionsInterface;

use function is_bool;
use function is_string;

final class LineItemFulfillmentInstructionsTransformer implements LineItemFulfillmentInstructionsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemFulfillmentInstructionsInterface
    {
        $lineItemFulfillmentInstructions = new LineItemFulfillmentInstructions();

        self::applyGuaranteedDelivery($lineItemFulfillmentInstructions, $data);
        self::applyMaxEstimatedDeliveryDate($lineItemFulfillmentInstructions, $data);
        self::applyMinEstimatedDeliveryDate($lineItemFulfillmentInstructions, $data);
        self::applyShipByDate($lineItemFulfillmentInstructions, $data);

        return $lineItemFulfillmentInstructions;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGuaranteedDelivery(LineItemFulfillmentInstructions $lineItemFulfillmentInstructions, array $data): void
    {
        if (!isset($data[self::KEY_GUARANTEED_DELIVERY])) {
            return;
        }
        if (!is_bool($data[self::KEY_GUARANTEED_DELIVERY])) {
            return;
        }
        $lineItemFulfillmentInstructions->setGuaranteedDelivery($data[self::KEY_GUARANTEED_DELIVERY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaxEstimatedDeliveryDate(LineItemFulfillmentInstructions $lineItemFulfillmentInstructions, array $data): void
    {
        if (empty($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $lineItemFulfillmentInstructions->setMaxEstimatedDeliveryDate($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMinEstimatedDeliveryDate(LineItemFulfillmentInstructions $lineItemFulfillmentInstructions, array $data): void
    {
        if (empty($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $lineItemFulfillmentInstructions->setMinEstimatedDeliveryDate($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShipByDate(LineItemFulfillmentInstructions $lineItemFulfillmentInstructions, array $data): void
    {
        if (empty($data[self::KEY_SHIP_BY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHIP_BY_DATE])) {
            return;
        }
        $lineItemFulfillmentInstructions->setShipByDate($data[self::KEY_SHIP_BY_DATE]);
    }
}
