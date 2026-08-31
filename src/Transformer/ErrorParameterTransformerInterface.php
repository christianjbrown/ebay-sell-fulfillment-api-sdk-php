<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameterInterface;

interface ErrorParameterTransformerInterface
{
    public const string KEY_NAME = 'name';
    public const string KEY_VALUE = 'value';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ErrorParameterInterface;
}
