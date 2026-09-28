<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PropertyInterface;

interface PropertyTransformerInterface
{
    public const string KEY_PROPERTY_DISPLAY_NAME = 'propertyDisplayName';
    public const string KEY_PROPERTY_NAME = 'propertyName';
    public const string KEY_PROPERTY_VALUE = 'propertyValue';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PropertyInterface;
}
