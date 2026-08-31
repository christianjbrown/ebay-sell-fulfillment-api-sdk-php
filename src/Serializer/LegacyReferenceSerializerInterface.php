<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LegacyReferenceInterface;

interface LegacyReferenceSerializerInterface
{
    public const string KEY_LEGACY_ITEM_ID = 'legacyItemId';
    public const string KEY_LEGACY_TRANSACTION_ID = 'legacyTransactionId';

    /**
     * @return array<string, mixed>
     */
    public function serialize(LegacyReferenceInterface $legacyReference): array;
}
