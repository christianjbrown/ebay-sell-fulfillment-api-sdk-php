<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

interface OrderLineItemTransformerInterface
{
    public const string KEY_ITEM_ID = 'itemId';
    public const string KEY_LINE_ITEM_ID = 'lineItemId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderLineItemInterface;
}
