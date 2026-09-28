<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefundInterface;

use function array_values;
use function count;

final class LineItemRefundsTransformer implements LineItemRefundsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private LineItemRefundTransformerInterface $lineItemRefundTransformer;

    public function __construct(LineItemRefundTransformerInterface $lineItemRefundTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->lineItemRefundTransformer = $lineItemRefundTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LineItemRefundInterface>
     */
    public function transform(array $data): array
    {
        $lineItemRefunds = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $lineItemRefunds[] = $this->lineItemRefundTransformer->transform($value);
        }

        return $lineItemRefunds;
    }
}
