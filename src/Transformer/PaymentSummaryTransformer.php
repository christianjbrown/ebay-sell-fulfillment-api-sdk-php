<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentSummary;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentSummaryInterface;

use function is_array;

final class PaymentSummaryTransformer implements PaymentSummaryTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;
    private OrderRefundsTransformerInterface $orderRefundsTransformer;
    private PaymentsTransformerInterface $paymentsTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer, OrderRefundsTransformerInterface $orderRefundsTransformer, PaymentsTransformerInterface $paymentsTransformer)
    {
        $this->amountTransformer = $amountTransformer;
        $this->orderRefundsTransformer = $orderRefundsTransformer;
        $this->paymentsTransformer = $paymentsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentSummaryInterface
    {
        $paymentSummary = new PaymentSummary();

        $this->applyPayments($paymentSummary, $data);
        $this->applyRefunds($paymentSummary, $data);
        $this->applyTotalDueSeller($paymentSummary, $data);

        return $paymentSummary;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPayments(PaymentSummary $paymentSummary, array $data): void
    {
        if (empty($data[self::KEY_PAYMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_PAYMENTS])) {
            return;
        }
        $paymentSummary->setPayments($this->paymentsTransformer->transform($data[self::KEY_PAYMENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRefunds(PaymentSummary $paymentSummary, array $data): void
    {
        if (empty($data[self::KEY_REFUNDS])) {
            return;
        }
        if (!is_array($data[self::KEY_REFUNDS])) {
            return;
        }
        $paymentSummary->setRefunds($this->orderRefundsTransformer->transform($data[self::KEY_REFUNDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTotalDueSeller(PaymentSummary $paymentSummary, array $data): void
    {
        if (empty($data[self::KEY_TOTAL_DUE_SELLER])) {
            return;
        }
        if (!is_array($data[self::KEY_TOTAL_DUE_SELLER])) {
            return;
        }
        $paymentSummary->setTotalDueSeller($this->amountTransformer->transform($data[self::KEY_TOTAL_DUE_SELLER]));
    }
}
