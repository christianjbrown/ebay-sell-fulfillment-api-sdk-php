<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentInterface;

interface PaymentTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_PAYMENT_DATE = 'paymentDate';
    public const string KEY_PAYMENT_HOLDS = 'paymentHolds';
    public const string KEY_PAYMENT_METHOD = 'paymentMethod';
    public const string KEY_PAYMENT_REFERENCE_ID = 'paymentReferenceId';
    public const string KEY_PAYMENT_STATUS = 'paymentStatus';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentInterface;
}
