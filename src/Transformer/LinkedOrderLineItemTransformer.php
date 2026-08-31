<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItem;
use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItemInterface;

use function is_array;
use function is_string;

final class LinkedOrderLineItemTransformer implements LinkedOrderLineItemTransformerInterface
{
    private NameValuePairsTransformerInterface $nameValuePairsTransformer;
    private TrackingInfosTransformerInterface $trackingInfosTransformer;

    public function __construct(NameValuePairsTransformerInterface $nameValuePairsTransformer, TrackingInfosTransformerInterface $trackingInfosTransformer)
    {
        $this->nameValuePairsTransformer = $nameValuePairsTransformer;
        $this->trackingInfosTransformer = $trackingInfosTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LinkedOrderLineItemInterface
    {
        $linkedOrderLineItem = new LinkedOrderLineItem();

        $this->applyLineItemAspects($linkedOrderLineItem, $data);
        self::applyLineItemId($linkedOrderLineItem, $data);
        self::applyMaxEstimatedDeliveryDate($linkedOrderLineItem, $data);
        self::applyMinEstimatedDeliveryDate($linkedOrderLineItem, $data);
        self::applyOrderId($linkedOrderLineItem, $data);
        self::applySellerId($linkedOrderLineItem, $data);
        $this->applyShipments($linkedOrderLineItem, $data);
        self::applyTitle($linkedOrderLineItem, $data);

        return $linkedOrderLineItem;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItemAspects(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_ASPECTS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEM_ASPECTS])) {
            return;
        }
        $linkedOrderLineItem->setLineItemAspects($this->nameValuePairsTransformer->transform($data[self::KEY_LINE_ITEM_ASPECTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLineItemId(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        $linkedOrderLineItem->setLineItemId($data[self::KEY_LINE_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaxEstimatedDeliveryDate(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $linkedOrderLineItem->setMaxEstimatedDeliveryDate($data[self::KEY_MAX_ESTIMATED_DELIVERY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMinEstimatedDeliveryDate(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE])) {
            return;
        }
        $linkedOrderLineItem->setMinEstimatedDeliveryDate($data[self::KEY_MIN_ESTIMATED_DELIVERY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOrderId(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_ORDER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ORDER_ID])) {
            return;
        }
        $linkedOrderLineItem->setOrderId($data[self::KEY_ORDER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySellerId(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_SELLER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SELLER_ID])) {
            return;
        }
        $linkedOrderLineItem->setSellerId($data[self::KEY_SELLER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShipments(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_SHIPMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPMENTS])) {
            return;
        }
        $linkedOrderLineItem->setShipments($this->trackingInfosTransformer->transform($data[self::KEY_SHIPMENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(LinkedOrderLineItem $linkedOrderLineItem, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $linkedOrderLineItem->setTitle($data[self::KEY_TITLE]);
    }
}
