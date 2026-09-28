<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;

use function array_values;
use function count;

final class OrderLineItemsTransformer implements OrderLineItemsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private OrderLineItemTransformerInterface $orderLineItemTransformer;

    public function __construct(OrderLineItemTransformerInterface $orderLineItemTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->orderLineItemTransformer = $orderLineItemTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderLineItemInterface>
     */
    public function transform(array $data): array
    {
        $orderLineItems = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $orderLineItems[] = $this->orderLineItemTransformer->transform($value);
        }

        return $orderLineItems;
    }
}
