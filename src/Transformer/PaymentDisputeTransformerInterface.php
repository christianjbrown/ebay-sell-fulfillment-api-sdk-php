<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeInterface;

interface PaymentDisputeTransformerInterface
{
    public const string KEY_AMOUNT = 'amount';
    public const string KEY_AVAILABLE_CHOICES = 'availableChoices';
    public const string KEY_BUYER_PROVIDED = 'buyerProvided';
    public const string KEY_BUYER_USERNAME = 'buyerUsername';
    public const string KEY_CLOSED_DATE = 'closedDate';
    public const string KEY_EVIDENCE = 'evidence';
    public const string KEY_EVIDENCE_REQUESTS = 'evidenceRequests';
    public const string KEY_LINE_ITEMS = 'lineItems';
    public const string KEY_MONETARY_TRANSACTIONS = 'monetaryTransactions';
    public const string KEY_NOTE = 'note';
    public const string KEY_OPEN_DATE = 'openDate';
    public const string KEY_ORDER_ID = 'orderId';
    public const string KEY_PAYMENT_DISPUTE_ID = 'paymentDisputeId';
    public const string KEY_PAYMENT_DISPUTE_STATUS = 'paymentDisputeStatus';
    public const string KEY_REASON = 'reason';
    public const string KEY_RESOLUTION = 'resolution';
    public const string KEY_RESPOND_BY_DATE = 'respondByDate';
    public const string KEY_RETURN_ADDRESS = 'returnAddress';
    public const string KEY_REVISION = 'revision';
    public const string KEY_SELLER_RESPONSE = 'sellerResponse';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeInterface;
}
