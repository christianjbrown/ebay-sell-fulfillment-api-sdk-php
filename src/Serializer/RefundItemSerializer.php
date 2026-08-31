<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\RefundItemInterface;

final class RefundItemSerializer implements RefundItemSerializerInterface
{
    private LegacyReferenceSerializerInterface $legacyReferenceSerializer;
    private SimpleAmountSerializerInterface $simpleAmountSerializer;

    public function __construct(LegacyReferenceSerializerInterface $legacyReferenceSerializer, SimpleAmountSerializerInterface $simpleAmountSerializer)
    {
        $this->legacyReferenceSerializer = $legacyReferenceSerializer;
        $this->simpleAmountSerializer = $simpleAmountSerializer;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(RefundItemInterface $refundItem): array
    {
        $data = [];

        $data = $this->applyLegacyReference($data, $refundItem);
        $data = self::applyLineItemId($data, $refundItem);
        $data = $this->applyRefundAmount($data, $refundItem);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyLegacyReference(array $data, RefundItemInterface $refundItem): array
    {
        $value = $refundItem->getLegacyReference();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_LEGACY_REFERENCE] = $this->legacyReferenceSerializer->serialize($value);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyLineItemId(array $data, RefundItemInterface $refundItem): array
    {
        $value = $refundItem->getLineItemId();
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
    private function applyRefundAmount(array $data, RefundItemInterface $refundItem): array
    {
        $value = $refundItem->getRefundAmount();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_REFUND_AMOUNT] = $this->simpleAmountSerializer->serialize($value);

        return $data;
    }
}
