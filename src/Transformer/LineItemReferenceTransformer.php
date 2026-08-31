<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReference;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

use function is_int;
use function is_string;

final class LineItemReferenceTransformer implements LineItemReferenceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemReferenceInterface
    {
        $lineItemReference = new LineItemReference();

        self::applyLineItemId($lineItemReference, $data);
        self::applyQuantity($lineItemReference, $data);

        return $lineItemReference;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLineItemId(LineItemReference $lineItemReference, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LINE_ITEM_ID])) {
            return;
        }
        $lineItemReference->setLineItemId($data[self::KEY_LINE_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyQuantity(LineItemReference $lineItemReference, array $data): void
    {
        if (!isset($data[self::KEY_QUANTITY])) {
            return;
        }
        if (!is_int($data[self::KEY_QUANTITY])) {
            return;
        }
        $lineItemReference->setQuantity($data[self::KEY_QUANTITY]);
    }
}
