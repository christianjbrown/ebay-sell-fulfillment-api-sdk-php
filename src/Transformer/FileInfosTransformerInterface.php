<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileInfoInterface;

interface FileInfosTransformerInterface
{
    public const string ARRAY_NAME = 'file_info';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, FileInfoInterface>
     */
    public function transform(array $data): array;
}
