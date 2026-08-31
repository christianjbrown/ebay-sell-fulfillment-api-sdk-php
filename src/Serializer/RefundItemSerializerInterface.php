<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\RefundItemInterface;

interface RefundItemSerializerInterface
{
    public const string KEY_LEGACY_REFERENCE = 'legacyReference';
    public const string KEY_LINE_ITEM_ID = 'lineItemId';
    public const string KEY_REFUND_AMOUNT = 'refundAmount';

    /**
     * @return array<string, mixed>
     */
    public function serialize(RefundItemInterface $refundItem): array;
}
