<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentHoldInterface;

interface PaymentHoldsTransformerInterface
{
    public const string ARRAY_NAME = 'payment_hold';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentHoldInterface>
     */
    public function transform(array $data): array;
}
