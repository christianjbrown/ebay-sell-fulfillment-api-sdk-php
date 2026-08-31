<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;

interface ShippingFulfillmentsTransformerInterface
{
    public const string ARRAY_NAME = 'shipping_fulfillment';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ShippingFulfillmentInterface>
     */
    public function transform(array $data): array;
}
