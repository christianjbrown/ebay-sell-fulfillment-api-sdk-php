<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\RefundItemInterface;

interface RefundItemsSerializerInterface
{
    /**
     * @param array<int, RefundItemInterface> $refundItems
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $refundItems): array;
}
