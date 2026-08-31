<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefundInterface;

interface LineItemRefundsTransformerInterface
{
    public const string ARRAY_NAME = 'line_item_refund';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, LineItemRefundInterface>
     */
    public function transform(array $data): array;
}
