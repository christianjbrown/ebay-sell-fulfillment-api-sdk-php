<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\RefundItemInterface;

use function array_values;
use function count;

final class RefundItemsSerializer implements RefundItemsSerializerInterface
{
    private RefundItemSerializerInterface $refundItemSerializer;

    public function __construct(RefundItemSerializerInterface $refundItemSerializer)
    {
        $this->refundItemSerializer = $refundItemSerializer;
    }

    /**
     * @param array<int, RefundItemInterface> $refundItems
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $refundItems): array
    {
        $data = [];
        $values = array_values($refundItems);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $data[] = $this->refundItemSerializer->serialize($values[$i]);
        }

        return $data;
    }
}
