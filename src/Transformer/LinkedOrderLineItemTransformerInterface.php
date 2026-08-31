<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItemInterface;

interface LinkedOrderLineItemTransformerInterface
{
    public const string KEY_LINE_ITEM_ASPECTS = 'lineItemAspects';
    public const string KEY_LINE_ITEM_ID = 'lineItemId';
    public const string KEY_MAX_ESTIMATED_DELIVERY_DATE = 'maxEstimatedDeliveryDate';
    public const string KEY_MIN_ESTIMATED_DELIVERY_DATE = 'minEstimatedDeliveryDate';
    public const string KEY_ORDER_ID = 'orderId';
    public const string KEY_SELLER_ID = 'sellerId';
    public const string KEY_SHIPMENTS = 'shipments';
    public const string KEY_TITLE = 'title';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LinkedOrderLineItemInterface;
}
