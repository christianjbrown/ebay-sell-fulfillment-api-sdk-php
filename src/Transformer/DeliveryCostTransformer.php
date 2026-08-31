<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DeliveryCost;
use ChristianBrown\EBay\SellFulfillment\Model\DeliveryCostInterface;

use function is_array;

final class DeliveryCostTransformer implements DeliveryCostTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeliveryCostInterface
    {
        $deliveryCost = new DeliveryCost();

        $this->applyDiscountAmount($deliveryCost, $data);
        $this->applyHandlingCost($deliveryCost, $data);
        $this->applyImportCharges($deliveryCost, $data);
        $this->applyShippingCost($deliveryCost, $data);
        $this->applyShippingIntermediationFee($deliveryCost, $data);

        return $deliveryCost;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDiscountAmount(DeliveryCost $deliveryCost, array $data): void
    {
        if (empty($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_DISCOUNT_AMOUNT])) {
            return;
        }
        $deliveryCost->setDiscountAmount($this->amountTransformer->transform($data[self::KEY_DISCOUNT_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHandlingCost(DeliveryCost $deliveryCost, array $data): void
    {
        if (empty($data[self::KEY_HANDLING_COST])) {
            return;
        }
        if (!is_array($data[self::KEY_HANDLING_COST])) {
            return;
        }
        $deliveryCost->setHandlingCost($this->amountTransformer->transform($data[self::KEY_HANDLING_COST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyImportCharges(DeliveryCost $deliveryCost, array $data): void
    {
        if (empty($data[self::KEY_IMPORT_CHARGES])) {
            return;
        }
        if (!is_array($data[self::KEY_IMPORT_CHARGES])) {
            return;
        }
        $deliveryCost->setImportCharges($this->amountTransformer->transform($data[self::KEY_IMPORT_CHARGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShippingCost(DeliveryCost $deliveryCost, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_COST])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPPING_COST])) {
            return;
        }
        $deliveryCost->setShippingCost($this->amountTransformer->transform($data[self::KEY_SHIPPING_COST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShippingIntermediationFee(DeliveryCost $deliveryCost, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_INTERMEDIATION_FEE])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPPING_INTERMEDIATION_FEE])) {
            return;
        }
        $deliveryCost->setShippingIntermediationFee($this->amountTransformer->transform($data[self::KEY_SHIPPING_INTERMEDIATION_FEE]));
    }
}
