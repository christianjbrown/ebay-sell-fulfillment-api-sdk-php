<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\IssueRefundRequestInterface;

interface IssueRefundRequestSerializerInterface
{
    public const string KEY_COMMENT = 'comment';
    public const string KEY_ORDER_LEVEL_REFUND_AMOUNT = 'orderLevelRefundAmount';
    public const string KEY_REASON_FOR_REFUND = 'reasonForRefund';
    public const string KEY_REFUND_ITEMS = 'refundItems';

    /**
     * @return array<string, mixed>
     */
    public function serialize(IssueRefundRequestInterface $issueRefundRequest): array;
}
