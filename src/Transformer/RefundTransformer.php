<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Refund;
use ChristianBrown\EBay\SellFulfillment\Model\RefundInterface;

use function is_string;

final class RefundTransformer implements RefundTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RefundInterface
    {
        $refund = new Refund();

        self::applyRefundId($refund, $data);
        self::applyRefundStatus($refund, $data);

        return $refund;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundId(Refund $refund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_ID])) {
            return;
        }
        $refund->setRefundId($data[self::KEY_REFUND_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundStatus(Refund $refund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_STATUS])) {
            return;
        }
        $refund->setRefundStatus($data[self::KEY_REFUND_STATUS]);
    }
}
