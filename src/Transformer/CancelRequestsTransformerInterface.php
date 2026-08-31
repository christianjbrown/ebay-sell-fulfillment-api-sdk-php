<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelRequestInterface;

interface CancelRequestsTransformerInterface
{
    public const string ARRAY_NAME = 'cancel_request';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, CancelRequestInterface>
     */
    public function transform(array $data): array;
}
