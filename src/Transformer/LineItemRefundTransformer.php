<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefund;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefundInterface;

use function is_array;
use function is_string;

final class LineItemRefundTransformer implements LineItemRefundTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LineItemRefundInterface
    {
        $lineItemRefund = new LineItemRefund();

        $this->applyAmount($lineItemRefund, $data);
        self::applyRefundDate($lineItemRefund, $data);
        self::applyRefundId($lineItemRefund, $data);
        self::applyRefundReferenceId($lineItemRefund, $data);

        return $lineItemRefund;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(LineItemRefund $lineItemRefund, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $lineItemRefund->setAmount($this->amountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundDate(LineItemRefund $lineItemRefund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_DATE])) {
            return;
        }
        $lineItemRefund->setRefundDate($data[self::KEY_REFUND_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundId(LineItemRefund $lineItemRefund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_ID])) {
            return;
        }
        $lineItemRefund->setRefundId($data[self::KEY_REFUND_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRefundReferenceId(LineItemRefund $lineItemRefund, array $data): void
    {
        if (empty($data[self::KEY_REFUND_REFERENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_REFUND_REFERENCE_ID])) {
            return;
        }
        $lineItemRefund->setRefundReferenceId($data[self::KEY_REFUND_REFERENCE_ID]);
    }
}
