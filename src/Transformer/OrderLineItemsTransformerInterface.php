<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

interface OrderLineItemsTransformerInterface
{
    public const string ARRAY_NAME = 'order_line_item';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderLineItemInterface>
     */
    public function transform(array $data): array;
}
