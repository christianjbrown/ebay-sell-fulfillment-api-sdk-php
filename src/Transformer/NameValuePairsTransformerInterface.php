<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\NameValuePairInterface;

interface NameValuePairsTransformerInterface
{
    public const string ARRAY_NAME = 'name_value_pair';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, NameValuePairInterface>
     */
    public function transform(array $data): array;
}
