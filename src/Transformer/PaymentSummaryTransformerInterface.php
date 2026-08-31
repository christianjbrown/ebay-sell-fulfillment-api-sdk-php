<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentSummaryInterface;

interface PaymentSummaryTransformerInterface
{
    public const string KEY_PAYMENTS = 'payments';
    public const string KEY_REFUNDS = 'refunds';
    public const string KEY_TOTAL_DUE_SELLER = 'totalDueSeller';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentSummaryInterface;
}
