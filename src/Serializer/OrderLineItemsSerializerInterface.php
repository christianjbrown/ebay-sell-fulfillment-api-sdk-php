<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

interface OrderLineItemsSerializerInterface
{
    /**
     * @param array<int, OrderLineItemInterface> $orderLineItems
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $orderLineItems): array;
}
