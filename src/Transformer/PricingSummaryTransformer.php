<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PricingSummary;
use ChristianBrown\EBay\SellFulfillment\Model\PricingSummaryInterface;

use function is_array;

final class PricingSummaryTransformer implements PricingSummaryTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PricingSummaryInterface
    {
        $pricingSummary = new PricingSummary();

        $this->applyAdjustment($pricingSummary, $data);
        $this->applyDeliveryCost($pricingSummary, $data);
        $this->applyDeliveryDiscount($pricingSummary, $data);
        $this->applyFee($pricingSummary, $data);
        $this->applyPriceDiscount($pricingSummary, $data);
        $this->applyPriceSubtotal($pricingSummary, $data);
        $this->applyTax($pricingSummary, $data);
        $this->applyTotal($pricingSummary, $data);

        return $pricingSummary;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAdjustment(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_ADJUSTMENT])) {
            return;
        }
        if (!is_array($data[self::KEY_ADJUSTMENT])) {
            return;
        }
        $pricingSummary->setAdjustment($this->amountTransformer->transform($data[self::KEY_ADJUSTMENT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeliveryCost(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_DELIVERY_COST])) {
            return;
        }
        if (!is_array($data[self::KEY_DELIVERY_COST])) {
            return;
        }
        $pricingSummary->setDeliveryCost($this->amountTransformer->transform($data[self::KEY_DELIVERY_COST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeliveryDiscount(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_DELIVERY_DISCOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_DELIVERY_DISCOUNT])) {
            return;
        }
        $pricingSummary->setDeliveryDiscount($this->amountTransformer->transform($data[self::KEY_DELIVERY_DISCOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFee(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_FEE])) {
            return;
        }
        if (!is_array($data[self::KEY_FEE])) {
            return;
        }
        $pricingSummary->setFee($this->amountTransformer->transform($data[self::KEY_FEE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPriceDiscount(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_PRICE_DISCOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_PRICE_DISCOUNT])) {
            return;
        }
        $pricingSummary->setPriceDiscount($this->amountTransformer->transform($data[self::KEY_PRICE_DISCOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPriceSubtotal(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_PRICE_SUBTOTAL])) {
            return;
        }
        if (!is_array($data[self::KEY_PRICE_SUBTOTAL])) {
            return;
        }
        $pricingSummary->setPriceSubtotal($this->amountTransformer->transform($data[self::KEY_PRICE_SUBTOTAL]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTax(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_TAX])) {
            return;
        }
        if (!is_array($data[self::KEY_TAX])) {
            return;
        }
        $pricingSummary->setTax($this->amountTransformer->transform($data[self::KEY_TAX]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTotal(PricingSummary $pricingSummary, array $data): void
    {
        if (empty($data[self::KEY_TOTAL])) {
            return;
        }
        if (!is_array($data[self::KEY_TOTAL])) {
            return;
        }
        $pricingSummary->setTotal($this->amountTransformer->transform($data[self::KEY_TOTAL]));
    }
}
