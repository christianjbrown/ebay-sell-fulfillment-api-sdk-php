<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;

use function array_values;
use function count;

final class OrdersTransformer implements OrdersTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private OrderTransformerInterface $orderTransformer;

    public function __construct(OrderTransformerInterface $orderTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->orderTransformer = $orderTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderInterface>
     */
    public function transform(array $data): array
    {
        $orders = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $orders[] = $this->orderTransformer->transform($value);
        }

        return $orders;
    }
}
