<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

use function array_values;
use function count;

final class LineItemReferencesSerializer implements LineItemReferencesSerializerInterface
{
    private LineItemReferenceSerializerInterface $lineItemReferenceSerializer;

    public function __construct(LineItemReferenceSerializerInterface $lineItemReferenceSerializer)
    {
        $this->lineItemReferenceSerializer = $lineItemReferenceSerializer;
    }

    /**
     * @param array<int, LineItemReferenceInterface> $lineItemReferences
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $lineItemReferences): array
    {
        $data = [];
        $values = array_values($lineItemReferences);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $data[] = $this->lineItemReferenceSerializer->serialize($values[$i]);
        }

        return $data;
    }
}
