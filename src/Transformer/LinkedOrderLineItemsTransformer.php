<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItemInterface;

use function array_values;
use function count;

final class LinkedOrderLineItemsTransformer implements LinkedOrderLineItemsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private LinkedOrderLineItemTransformerInterface $linkedOrderLineItemTransformer;

    public function __construct(LinkedOrderLineItemTransformerInterface $linkedOrderLineItemTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->linkedOrderLineItemTransformer = $linkedOrderLineItemTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LinkedOrderLineItemInterface>
     */
    public function transform(array $data): array
    {
        $linkedOrderLineItems = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $linkedOrderLineItems[] = $this->linkedOrderLineItemTransformer->transform($value);
        }

        return $linkedOrderLineItems;
    }
}
