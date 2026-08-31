<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummary;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummaryInterface;

use function is_array;
use function is_string;

final class PaymentDisputeSummaryTransformer implements PaymentDisputeSummaryTransformerInterface
{
    private SimpleAmountTransformerInterface $simpleAmountTransformer;

    public function __construct(SimpleAmountTransformerInterface $simpleAmountTransformer)
    {
        $this->simpleAmountTransformer = $simpleAmountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeSummaryInterface
    {
        $paymentDisputeSummary = new PaymentDisputeSummary();

        $this->applyAmount($paymentDisputeSummary, $data);
        self::applyBuyerUsername($paymentDisputeSummary, $data);
        self::applyClosedDate($paymentDisputeSummary, $data);
        self::applyOpenDate($paymentDisputeSummary, $data);
        self::applyOrderId($paymentDisputeSummary, $data);
        self::applyPaymentDisputeId($paymentDisputeSummary, $data);
        self::applyPaymentDisputeStatus($paymentDisputeSummary, $data);
        self::applyReason($paymentDisputeSummary, $data);
        self::applyRespondByDate($paymentDisputeSummary, $data);

        return $paymentDisputeSummary;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $paymentDisputeSummary->setAmount($this->simpleAmountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBuyerUsername(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_BUYER_USERNAME])) {
            return;
        }
        if (!is_string($data[self::KEY_BUYER_USERNAME])) {
            return;
        }
        $paymentDisputeSummary->setBuyerUsername($data[self::KEY_BUYER_USERNAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyClosedDate(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_CLOSED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CLOSED_DATE])) {
            return;
        }
        $paymentDisputeSummary->setClosedDate($data[self::KEY_CLOSED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOpenDate(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_OPEN_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_OPEN_DATE])) {
            return;
        }
        $paymentDisputeSummary->setOpenDate($data[self::KEY_OPEN_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOrderId(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_ORDER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ORDER_ID])) {
            return;
        }
        $paymentDisputeSummary->setOrderId($data[self::KEY_ORDER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentDisputeId(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_DISPUTE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_DISPUTE_ID])) {
            return;
        }
        $paymentDisputeSummary->setPaymentDisputeId($data[self::KEY_PAYMENT_DISPUTE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentDisputeStatus(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_DISPUTE_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_DISPUTE_STATUS])) {
            return;
        }
        $paymentDisputeSummary->setPaymentDisputeStatus($data[self::KEY_PAYMENT_DISPUTE_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReason(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_REASON])) {
            return;
        }
        if (!is_string($data[self::KEY_REASON])) {
            return;
        }
        $paymentDisputeSummary->setReason($data[self::KEY_REASON]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRespondByDate(PaymentDisputeSummary $paymentDisputeSummary, array $data): void
    {
        if (empty($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        $paymentDisputeSummary->setRespondByDate($data[self::KEY_RESPOND_BY_DATE]);
    }
}
