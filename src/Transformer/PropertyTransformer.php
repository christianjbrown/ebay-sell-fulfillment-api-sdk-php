<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Property;
use ChristianBrown\EBay\SellFulfillment\Model\PropertyInterface;

use function is_string;

final class PropertyTransformer implements PropertyTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PropertyInterface
    {
        $property = new Property();

        self::applyPropertyDisplayName($property, $data);
        self::applyPropertyName($property, $data);
        self::applyPropertyValue($property, $data);

        return $property;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPropertyDisplayName(Property $property, array $data): void
    {
        if (empty($data[self::KEY_PROPERTY_DISPLAY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_PROPERTY_DISPLAY_NAME])) {
            return;
        }
        $property->setPropertyDisplayName($data[self::KEY_PROPERTY_DISPLAY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPropertyName(Property $property, array $data): void
    {
        if (empty($data[self::KEY_PROPERTY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_PROPERTY_NAME])) {
            return;
        }
        $property->setPropertyName($data[self::KEY_PROPERTY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPropertyValue(Property $property, array $data): void
    {
        if (empty($data[self::KEY_PROPERTY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_PROPERTY_VALUE])) {
            return;
        }
        $property->setPropertyValue($data[self::KEY_PROPERTY_VALUE]);
    }
}
