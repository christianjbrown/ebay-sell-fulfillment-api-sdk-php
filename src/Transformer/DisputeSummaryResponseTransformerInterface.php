<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeSummaryResponseInterface;

interface DisputeSummaryResponseTransformerInterface
{
    public const string KEY_HREF = 'href';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_NEXT = 'next';
    public const string KEY_OFFSET = 'offset';
    public const string KEY_PAYMENT_DISPUTE_SUMMARIES = 'paymentDisputeSummaries';
    public const string KEY_PREV = 'prev';
    public const string KEY_TOTAL = 'total';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DisputeSummaryResponseInterface;
}
