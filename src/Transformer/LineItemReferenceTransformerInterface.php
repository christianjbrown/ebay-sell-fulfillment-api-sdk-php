<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

interface LineItemReferenceTransformerInterface
{
    public const string KEY_LINE_ITEM_ID = 'lineItemId';
    public const string KEY_QUANTITY = 'quantity';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemReferenceInterface;
}
