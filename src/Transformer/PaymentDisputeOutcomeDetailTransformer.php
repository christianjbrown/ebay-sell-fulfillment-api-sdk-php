<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeOutcomeDetail;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeOutcomeDetailInterface;

use function is_array;
use function is_string;

final class PaymentDisputeOutcomeDetailTransformer implements PaymentDisputeOutcomeDetailTransformerInterface
{
    private SimpleAmountTransformerInterface $simpleAmountTransformer;

    public function __construct(SimpleAmountTransformerInterface $simpleAmountTransformer)
    {
        $this->simpleAmountTransformer = $simpleAmountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeOutcomeDetailInterface
    {
        $paymentDisputeOutcomeDetail = new PaymentDisputeOutcomeDetail();

        $this->applyDonationCreditAmount($paymentDisputeOutcomeDetail, $data);
        $this->applyFees($paymentDisputeOutcomeDetail, $data);
        $this->applyProtectedAmount($paymentDisputeOutcomeDetail, $data);
        self::applyProtectionStatus($paymentDisputeOutcomeDetail, $data);
        self::applyReasonForClosure($paymentDisputeOutcomeDetail, $data);
        $this->applyRecoupAmount($paymentDisputeOutcomeDetail, $data);
        $this->applyTotalFeeCredit($paymentDisputeOutcomeDetail, $data);

        return $paymentDisputeOutcomeDetail;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDonationCreditAmount(PaymentDisputeOutcomeDetail $paymentDisputeOutcomeDetail, array $data): void
    {
        if (empty($data[self::KEY_DONATION_CREDIT_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_DONATION_CREDIT_AMOUNT])) {
            return;
        }
        $paymentDisputeOutcomeDetail->setDonationCreditAmount($this->simpleAmountTransformer->transform($data[self::KEY_DONATION_CREDIT_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFees(PaymentDisputeOutcomeDetail $paymentDisputeOutcomeDetail, array $data): void
    {
        if (empty($data[self::KEY_FEES])) {
            return;
        }
        if (!is_array($data[self::KEY_FEES])) {
            return;
        }
        $paymentDisputeOutcomeDetail->setFees($this->simpleAmountTransformer->transform($data[self::KEY_FEES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProtectedAmount(PaymentDisputeOutcomeDetail $paymentDisputeOutcomeDetail, array $data): void
    {
        if (empty($data[self::KEY_PROTECTED_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_PROTECTED_AMOUNT])) {
            return;
        }
        $paymentDisputeOutcomeDetail->setProtectedAmount($this->simpleAmountTransformer->transform($data[self::KEY_PROTECTED_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProtectionStatus(PaymentDisputeOutcomeDetail $paymentDisputeOutcomeDetail, array $data): void
    {
        if (empty($data[self::KEY_PROTECTION_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_PROTECTION_STATUS])) {
            return;
        }
        $paymentDisputeOutcomeDetail->setProtectionStatus($data[self::KEY_PROTECTION_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReasonForClosure(PaymentDisputeOutcomeDetail $paymentDisputeOutcomeDetail, array $data): void
    {
        if (empty($data[self::KEY_REASON_FOR_CLOSURE])) {
            return;
        }
        if (!is_string($data[self::KEY_REASON_FOR_CLOSURE])) {
            return;
        }
        $paymentDisputeOutcomeDetail->setReasonForClosure($data[self::KEY_REASON_FOR_CLOSURE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRecoupAmount(PaymentDisputeOutcomeDetail $paymentDisputeOutcomeDetail, array $data): void
    {
        if (empty($data[self::KEY_RECOUP_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_RECOUP_AMOUNT])) {
            return;
        }
        $paymentDisputeOutcomeDetail->setRecoupAmount($this->simpleAmountTransformer->transform($data[self::KEY_RECOUP_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTotalFeeCredit(PaymentDisputeOutcomeDetail $paymentDisputeOutcomeDetail, array $data): void
    {
        if (empty($data[self::KEY_TOTAL_FEE_CREDIT])) {
            return;
        }
        if (!is_array($data[self::KEY_TOTAL_FEE_CREDIT])) {
            return;
        }
        $paymentDisputeOutcomeDetail->setTotalFeeCredit($this->simpleAmountTransformer->transform($data[self::KEY_TOTAL_FEE_CREDIT]));
    }
}
