<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItemInterface;

interface LinkedOrderLineItemsTransformerInterface
{
    public const string ARRAY_NAME = 'linked_order_line_item';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, LinkedOrderLineItemInterface>
     */
    public function transform(array $data): array;
}
