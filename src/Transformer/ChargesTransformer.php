<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ChargeInterface;

use function array_values;
use function count;

final class ChargesTransformer implements ChargesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private ChargeTransformerInterface $chargeTransformer;

    public function __construct(ChargeTransformerInterface $chargeTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->chargeTransformer = $chargeTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ChargeInterface>
     */
    public function transform(array $data): array
    {
        $charges = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $charges[] = $this->chargeTransformer->transform($value);
        }

        return $charges;
    }
}
