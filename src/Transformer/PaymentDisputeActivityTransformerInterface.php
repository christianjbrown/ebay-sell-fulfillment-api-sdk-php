<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityInterface;

interface PaymentDisputeActivityTransformerInterface
{
    public const string KEY_ACTIVITY_DATE = 'activityDate';
    public const string KEY_ACTIVITY_TYPE = 'activityType';
    public const string KEY_ACTOR = 'actor';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeActivityInterface;
}
