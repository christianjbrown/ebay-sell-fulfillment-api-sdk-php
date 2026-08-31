<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderRefundInterface;

interface OrderRefundTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_REFUND_DATE = 'refundDate';
    public const string KEY_REFUND_ID = 'refundId';
    public const string KEY_REFUND_REFERENCE_ID = 'refundReferenceId';
    public const string KEY_REFUND_STATUS = 'refundStatus';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderRefundInterface;
}
