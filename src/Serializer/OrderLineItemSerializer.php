<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

final class OrderLineItemSerializer implements OrderLineItemSerializerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(OrderLineItemInterface $orderLineItem): array
    {
        $data = [];

        $data = self::applyItemId($data, $orderLineItem);
        $data = self::applyLineItemId($data, $orderLineItem);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyItemId(array $data, OrderLineItemInterface $orderLineItem): array
    {
        $value = $orderLineItem->getItemId();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_ITEM_ID] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyLineItemId(array $data, OrderLineItemInterface $orderLineItem): array
    {
        $value = $orderLineItem->getLineItemId();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_LINE_ITEM_ID] = $value;

        return $data;
    }
}
