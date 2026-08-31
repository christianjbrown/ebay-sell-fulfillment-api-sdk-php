<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentPagedCollectionInterface;

interface ShippingFulfillmentPagedCollectionTransformerInterface
{
    public const string KEY_FULFILLMENTS = 'fulfillments';
    public const string KEY_TOTAL = 'total';
    public const string KEY_WARNINGS = 'warnings';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingFulfillmentPagedCollectionInterface;
}
