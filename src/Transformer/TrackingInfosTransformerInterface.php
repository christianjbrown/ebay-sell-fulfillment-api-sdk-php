<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;

interface TrackingInfosTransformerInterface
{
    public const string ARRAY_NAME = 'tracking_info';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, TrackingInfoInterface>
     */
    public function transform(array $data): array;
}
