<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummaryInterface;

interface PaymentDisputeSummaryTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_BUYER_USERNAME = 'buyerUsername';
    public const string KEY_CLOSED_DATE = 'closedDate';
    public const string KEY_OPEN_DATE = 'openDate';
    public const string KEY_ORDER_ID = 'orderId';
    public const string KEY_PAYMENT_DISPUTE_ID = 'paymentDisputeId';
    public const string KEY_PAYMENT_DISPUTE_STATUS = 'paymentDisputeStatus';
    public const string KEY_REASON = 'reason';
    public const string KEY_RESPOND_BY_DATE = 'respondByDate';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeSummaryInterface;
}
