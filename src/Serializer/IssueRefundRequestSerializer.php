<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\IssueRefundRequestInterface;

final class IssueRefundRequestSerializer implements IssueRefundRequestSerializerInterface
{
    private RefundItemsSerializerInterface $refundItemsSerializer;
    private SimpleAmountSerializerInterface $simpleAmountSerializer;

    public function __construct(RefundItemsSerializerInterface $refundItemsSerializer, SimpleAmountSerializerInterface $simpleAmountSerializer)
    {
        $this->refundItemsSerializer = $refundItemsSerializer;
        $this->simpleAmountSerializer = $simpleAmountSerializer;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(IssueRefundRequestInterface $issueRefundRequest): array
    {
        $data = [];

        $data = self::applyComment($data, $issueRefundRequest);
        $data = $this->applyOrderLevelRefundAmount($data, $issueRefundRequest);
        $data = self::applyReasonForRefund($data, $issueRefundRequest);
        $data = $this->applyRefundItems($data, $issueRefundRequest);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyComment(array $data, IssueRefundRequestInterface $issueRefundRequest): array
    {
        $value = $issueRefundRequest->getComment();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_COMMENT] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyOrderLevelRefundAmount(array $data, IssueRefundRequestInterface $issueRefundRequest): array
    {
        $value = $issueRefundRequest->getOrderLevelRefundAmount();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_ORDER_LEVEL_REFUND_AMOUNT] = $this->simpleAmountSerializer->serialize($value);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyReasonForRefund(array $data, IssueRefundRequestInterface $issueRefundRequest): array
    {
        $value = $issueRefundRequest->getReasonForRefund();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_REASON_FOR_REFUND] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyRefundItems(array $data, IssueRefundRequestInterface $issueRefundRequest): array
    {
        $value = $issueRefundRequest->getRefundItems();
        if (empty($value)) {
            return $data;
        }
        $data[self::KEY_REFUND_ITEMS] = $this->refundItemsSerializer->serialize($value);

        return $data;
    }
}
