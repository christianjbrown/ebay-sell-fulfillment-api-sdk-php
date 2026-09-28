<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderRefundInterface;

use function array_values;
use function count;

final class OrderRefundsTransformer implements OrderRefundsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private OrderRefundTransformerInterface $orderRefundTransformer;

    public function __construct(OrderRefundTransformerInterface $orderRefundTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->orderRefundTransformer = $orderRefundTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderRefundInterface>
     */
    public function transform(array $data): array
    {
        $orderRefunds = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $orderRefunds[] = $this->orderRefundTransformer->transform($value);
        }

        return $orderRefunds;
    }
}
