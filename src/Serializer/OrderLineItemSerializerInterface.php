<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

interface OrderLineItemSerializerInterface
{
    public const string KEY_ITEM_ID = 'itemId';
    public const string KEY_LINE_ITEM_ID = 'lineItemId';

    /**
     * @return array<string, mixed>
     */
    public function serialize(OrderLineItemInterface $orderLineItem): array;
}
