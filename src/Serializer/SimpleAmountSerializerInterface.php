<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;

interface SimpleAmountSerializerInterface
{
    public const string KEY_CURRENCY = 'currency';
    public const string KEY_VALUE = 'value';

    /**
     * @return array<string, mixed>
     */
    public function serialize(SimpleAmountInterface $simpleAmount): array;
}
