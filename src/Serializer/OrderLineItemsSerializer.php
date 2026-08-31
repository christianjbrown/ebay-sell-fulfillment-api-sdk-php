<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

use function array_values;
use function count;

final class OrderLineItemsSerializer implements OrderLineItemsSerializerInterface
{
    private OrderLineItemSerializerInterface $orderLineItemSerializer;

    public function __construct(OrderLineItemSerializerInterface $orderLineItemSerializer)
    {
        $this->orderLineItemSerializer = $orderLineItemSerializer;
    }

    /**
     * @param array<int, OrderLineItemInterface> $orderLineItems
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $orderLineItems): array
    {
        $data = [];
        $values = array_values($orderLineItems);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $data[] = $this->orderLineItemSerializer->serialize($values[$i]);
        }

        return $data;
    }
}
