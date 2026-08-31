<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderRefund;
use ChristianBrown\EBay\SellFulfillment\Model\OrderRefundInterface;

use function is_array;
use function is_string;

final class OrderRefundTransformer implements OrderRefundTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderRefundInterface
    {
        $orderRefund = new OrderRefund();

        $this->applyAmount($orderRefund, $data);
        self::applyRefundDate($orderRefund, $data);
        self::applyRefundId($orderRefund, $data);
        self::applyRefundReferenceId($orderRefund, $data);
        self::applyRefundStatus($orderRefund, $data);

        return $orderRefund;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(OrderRefund $orderRefund, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $orderRefund->setAmount($this->amountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundDate(OrderRefund $orderRefund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_DATE])) {
            return;
        }
        $orderRefund->setRefundDate($data[self::KEY_REFUND_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundId(OrderRefund $orderRefund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_ID])) {
            return;
        }
        $orderRefund->setRefundId($data[self::KEY_REFUND_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundReferenceId(OrderRefund $orderRefund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_REFERENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_REFERENCE_ID])) {
            return;
        }
        $orderRefund->setRefundReferenceId($data[self::KEY_REFUND_REFERENCE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundStatus(OrderRefund $orderRefund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_STATUS])) {
            return;
        }
        $orderRefund->setRefundStatus($data[self::KEY_REFUND_STATUS]);
    }
}
