<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityHistoryInterface;

interface PaymentDisputeActivityHistoryTransformerInterface
{
    public const string KEY_ACTIVITY = 'activity';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeActivityHistoryInterface;
}
