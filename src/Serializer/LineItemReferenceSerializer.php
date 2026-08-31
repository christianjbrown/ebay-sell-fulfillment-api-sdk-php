<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

final class LineItemReferenceSerializer implements LineItemReferenceSerializerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(LineItemReferenceInterface $lineItemReference): array
    {
        $data = [];

        $data = self::applyLineItemId($data, $lineItemReference);
        $data = self::applyQuantity($data, $lineItemReference);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyLineItemId(array $data, LineItemReferenceInterface $lineItemReference): array
    {
        $value = $lineItemReference->getLineItemId();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_LINE_ITEM_ID] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyQuantity(array $data, LineItemReferenceInterface $lineItemReference): array
    {
        $value = $lineItemReference->getQuantity();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_QUANTITY] = $value;

        return $data;
    }
}
