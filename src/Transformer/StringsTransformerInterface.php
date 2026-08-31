<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

interface StringsTransformerInterface
{
    public const string ARRAY_NAME = 'string';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    public function transform(array $data): array;
}
