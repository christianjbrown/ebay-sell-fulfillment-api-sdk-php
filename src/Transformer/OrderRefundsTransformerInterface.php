<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderRefundInterface;

interface OrderRefundsTransformerInterface
{
    public const string ARRAY_NAME = 'order_refund';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderRefundInterface>
     */
    public function transform(array $data): array;
}
