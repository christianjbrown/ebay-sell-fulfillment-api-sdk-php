<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItem;
use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

use function is_string;

final class OrderLineItemTransformer implements OrderLineItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderLineItemInterface
    {
        $orderLineItem = new OrderLineItem();

        self::applyItemId($orderLineItem, $data);
        self::applyLineItemId($orderLineItem, $data);

        return $orderLineItem;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemId(OrderLineItem $orderLineItem, array $data): void
    {
        if (empty($data[self::KEY_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_ID])) {
            return;
        }
        $orderLineItem->setItemId($data[self::KEY_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLineItemId(OrderLineItem $orderLineItem, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        $orderLineItem->setLineItemId($data[self::KEY_LINE_ITEM_ID]);
    }
}
