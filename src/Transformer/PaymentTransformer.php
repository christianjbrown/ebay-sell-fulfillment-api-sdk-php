<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Payment;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentInterface;

use function is_array;
use function is_string;

final class PaymentTransformer implements PaymentTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;
    private PaymentHoldsTransformerInterface $paymentHoldsTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer, PaymentHoldsTransformerInterface $paymentHoldsTransformer)
    {
        $this->amountTransformer = $amountTransformer;
        $this->paymentHoldsTransformer = $paymentHoldsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentInterface
    {
        $payment = new Payment();

        $this->applyAmount($payment, $data);
        self::applyPaymentDate($payment, $data);
        $this->applyPaymentHolds($payment, $data);
        self::applyPaymentMethod($payment, $data);
        self::applyPaymentReferenceId($payment, $data);
        self::applyPaymentStatus($payment, $data);

        return $payment;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(Payment $payment, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $payment->setAmount($this->amountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentDate(Payment $payment, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_DATE])) {
            return;
        }
        $payment->setPaymentDate($data[self::KEY_PAYMENT_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPaymentHolds(Payment $payment, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_HOLDS])) {
            return;
        }
        if (!is_array($data[self::KEY_PAYMENT_HOLDS])) {
            return;
        }
        $payment->setPaymentHolds($this->paymentHoldsTransformer->transform($data[self::KEY_PAYMENT_HOLDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentMethod(Payment $payment, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_METHOD])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_METHOD])) {
            return;
        }
        $payment->setPaymentMethod($data[self::KEY_PAYMENT_METHOD]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentReferenceId(Payment $payment, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_REFERENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_REFERENCE_ID])) {
            return;
        }
        $payment->setPaymentReferenceId($data[self::KEY_PAYMENT_REFERENCE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentStatus(Payment $payment, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_STATUS])) {
            return;
        }
        $payment->setPaymentStatus($data[self::KEY_PAYMENT_STATUS]);
    }
}
