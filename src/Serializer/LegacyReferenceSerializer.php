<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LegacyReferenceInterface;

final class LegacyReferenceSerializer implements LegacyReferenceSerializerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(LegacyReferenceInterface $legacyReference): array
    {
        $data = [];

        $data = self::applyLegacyItemId($data, $legacyReference);
        $data = self::applyLegacyTransactionId($data, $legacyReference);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyLegacyItemId(array $data, LegacyReferenceInterface $legacyReference): array
    {
        $value = $legacyReference->getLegacyItemId();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_LEGACY_ITEM_ID] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyLegacyTransactionId(array $data, LegacyReferenceInterface $legacyReference): array
    {
        $value = $legacyReference->getLegacyTransactionId();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_LEGACY_TRANSACTION_ID] = $value;

        return $data;
    }
}
