<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameterInterface;

interface ErrorParametersTransformerInterface
{
    public const string ARRAY_NAME = 'error_parameter';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ErrorParameterInterface>
     */
    public function transform(array $data): array;
}
