<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxInterface;

use function array_values;
use function count;

final class TaxesTransformer implements TaxesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private TaxTransformerInterface $taxTransformer;

    public function __construct(TaxTransformerInterface $taxTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->taxTransformer = $taxTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TaxInterface>
     */
    public function transform(array $data): array
    {
        $taxes = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $taxes[] = $this->taxTransformer->transform($value);
        }

        return $taxes;
    }
}
