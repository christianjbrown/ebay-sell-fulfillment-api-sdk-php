<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ChargeInterface;

interface ChargesTransformerInterface
{
    public const string ARRAY_NAME = 'charge';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ChargeInterface>
     */
    public function transform(array $data): array;
}
