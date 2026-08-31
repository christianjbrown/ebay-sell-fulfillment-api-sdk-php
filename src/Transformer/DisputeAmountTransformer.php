<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeAmount;
use ChristianBrown\EBay\SellFulfillment\Model\DisputeAmountInterface;

use function is_string;

final class DisputeAmountTransformer implements DisputeAmountTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DisputeAmountInterface
    {
        $disputeAmount = new DisputeAmount();

        self::applyConvertedFromCurrency($disputeAmount, $data);
        self::applyConvertedFromValue($disputeAmount, $data);
        self::applyCurrency($disputeAmount, $data);
        self::applyExchangeRate($disputeAmount, $data);
        self::applyValue($disputeAmount, $data);

        return $disputeAmount;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConvertedFromCurrency(DisputeAmount $disputeAmount, array $data): void
    {
        if (empty($data[self::KEY_CONVERTED_FROM_CURRENCY])) {
            return;
        }
        if (!is_string($data[self::KEY_CONVERTED_FROM_CURRENCY])) {
            return;
        }
        $disputeAmount->setConvertedFromCurrency($data[self::KEY_CONVERTED_FROM_CURRENCY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConvertedFromValue(DisputeAmount $disputeAmount, array $data): void
    {
        if (empty($data[self::KEY_CONVERTED_FROM_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_CONVERTED_FROM_VALUE])) {
            return;
        }
        $disputeAmount->setConvertedFromValue($data[self::KEY_CONVERTED_FROM_VALUE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCurrency(DisputeAmount $disputeAmount, array $data): void
    {
        if (empty($data[self::KEY_CURRENCY])) {
            return;
        }
        if (!is_string($data[self::KEY_CURRENCY])) {
            return;
        }
        $disputeAmount->setCurrency($data[self::KEY_CURRENCY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExchangeRate(DisputeAmount $disputeAmount, array $data): void
    {
        if (empty($data[self::KEY_EXCHANGE_RATE])) {
            return;
        }
        if (!is_string($data[self::KEY_EXCHANGE_RATE])) {
            return;
        }
        $disputeAmount->setExchangeRate($data[self::KEY_EXCHANGE_RATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(DisputeAmount $disputeAmount, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $disputeAmount->setValue($data[self::KEY_VALUE]);
    }
}
