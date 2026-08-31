<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorInterface;

interface ErrorsTransformerInterface
{
    public const string ARRAY_NAME = 'error';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ErrorInterface>
     */
    public function transform(array $data): array;
}
