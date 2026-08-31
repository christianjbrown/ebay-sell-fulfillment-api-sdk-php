<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

interface LineItemReferencesSerializerInterface
{
    /**
     * @param array<int, LineItemReferenceInterface> $lineItemReferences
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $lineItemReferences): array;
}
