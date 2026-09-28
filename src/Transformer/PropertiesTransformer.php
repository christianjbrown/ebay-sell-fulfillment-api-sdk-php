<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PropertyInterface;

use function array_values;
use function count;

final class PropertiesTransformer implements PropertiesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private PropertyTransformerInterface $propertyTransformer;

    public function __construct(PropertyTransformerInterface $propertyTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->propertyTransformer = $propertyTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PropertyInterface>
     */
    public function transform(array $data): array
    {
        $properties = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $properties[] = $this->propertyTransformer->transform($value);
        }

        return $properties;
    }
}
