<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

interface LineItemReferenceSerializerInterface
{
    public const string KEY_LINE_ITEM_ID = 'lineItemId';
    public const string KEY_QUANTITY = 'quantity';

    /**
     * @return array<string, mixed>
     */
    public function serialize(LineItemReferenceInterface $lineItemReference): array;
}
