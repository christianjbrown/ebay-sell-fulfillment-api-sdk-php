<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PricingSummaryInterface;

interface PricingSummaryTransformerInterface
{
    public const string KEY_ADJUSTMENT = 'adjustment';
    public const string KEY_DELIVERY_COST = 'deliveryCost';
    public const string KEY_DELIVERY_DISCOUNT = 'deliveryDiscount';
    public const string KEY_FEE = 'fee';
    public const string KEY_PRICE_DISCOUNT = 'priceDiscount';
    public const string KEY_PRICE_SUBTOTAL = 'priceSubtotal';
    public const string KEY_TAX = 'tax';
    public const string KEY_TOTAL = 'total';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PricingSummaryInterface;
}
