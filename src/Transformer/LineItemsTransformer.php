<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemInterface;

use function array_values;
use function count;

final class LineItemsTransformer implements LineItemsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private LineItemTransformerInterface $lineItemTransformer;

    public function __construct(LineItemTransformerInterface $lineItemTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->lineItemTransformer = $lineItemTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LineItemInterface>
     */
    public function transform(array $data): array
    {
        $lineItems = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $lineItems[] = $this->lineItemTransformer->transform($value);
        }

        return $lineItems;
    }
}
