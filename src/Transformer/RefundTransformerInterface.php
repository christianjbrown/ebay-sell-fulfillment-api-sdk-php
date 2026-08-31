<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\RefundInterface;

interface RefundTransformerInterface
{
    public const string KEY_REFUND_ID = 'refundId';
    public const string KEY_REFUND_STATUS = 'refundStatus';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RefundInterface;
}
