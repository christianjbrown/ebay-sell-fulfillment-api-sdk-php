<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummaryInterface;

interface PaymentDisputeSummariesTransformerInterface
{
    public const string ARRAY_NAME = 'payment_dispute_summary';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentDisputeSummaryInterface>
     */
    public function transform(array $data): array;
}
