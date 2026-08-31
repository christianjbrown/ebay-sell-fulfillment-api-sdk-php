<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityInterface;

interface PaymentDisputeActivitiesTransformerInterface
{
    public const string ARRAY_NAME = 'payment_dispute_activity';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentDisputeActivityInterface>
     */
    public function transform(array $data): array;
}
