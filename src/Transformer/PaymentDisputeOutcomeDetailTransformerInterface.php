<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeOutcomeDetailInterface;

interface PaymentDisputeOutcomeDetailTransformerInterface
{
    public const string KEY_FEES = 'fees';
    public const string KEY_PROTECTED_AMOUNT = 'protectedAmount';
    public const string KEY_PROTECTION_STATUS = 'protectionStatus';
    public const string KEY_REASON_FOR_CLOSURE = 'reasonForClosure';
    public const string KEY_RECOUP_AMOUNT = 'recoupAmount';
    public const string KEY_TOTAL_FEE_CREDIT = 'totalFeeCredit';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeOutcomeDetailInterface;
}
