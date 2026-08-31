<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Amount;
use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;

use function is_string;

final class AmountTransformer implements AmountTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AmountInterface
    {
        $amount = new Amount();

        self::applyConvertedFromCurrency($amount, $data);
        self::applyConvertedFromValue($amount, $data);
        self::applyCurrency($amount, $data);
        self::applyValue($amount, $data);

        return $amount;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConvertedFromCurrency(Amount $amount, array $data): void
    {
        if (empty($data[self::KEY_CONVERTED_FROM_CURRENCY])) {
            return;
        }
        if (!is_string($data[self::KEY_CONVERTED_FROM_CURRENCY])) {
            return;
        }
        $amount->setConvertedFromCurrency($data[self::KEY_CONVERTED_FROM_CURRENCY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConvertedFromValue(Amount $amount, array $data): void
    {
        if (empty($data[self::KEY_CONVERTED_FROM_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_CONVERTED_FROM_VALUE])) {
            return;
        }
        $amount->setConvertedFromValue($data[self::KEY_CONVERTED_FROM_VALUE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCurrency(Amount $amount, array $data): void
    {
        if (empty($data[self::KEY_CURRENCY])) {
            return;
        }
        if (!is_string($data[self::KEY_CURRENCY])) {
            return;
        }
        $amount->setCurrency($data[self::KEY_CURRENCY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(Amount $amount, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $amount->setValue($data[self::KEY_VALUE]);
    }
}
