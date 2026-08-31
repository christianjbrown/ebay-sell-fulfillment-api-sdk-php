<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmount;
use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;

use function is_string;

final class SimpleAmountTransformer implements SimpleAmountTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SimpleAmountInterface
    {
        $simpleAmount = new SimpleAmount();

        self::applyCurrency($simpleAmount, $data);
        self::applyValue($simpleAmount, $data);

        return $simpleAmount;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCurrency(SimpleAmount $simpleAmount, array $data): void
    {
        if (empty($data[self::KEY_CURRENCY])) {
            return;
        }
        if (!is_string($data[self::KEY_CURRENCY])) {
            return;
        }
        $simpleAmount->setCurrency($data[self::KEY_CURRENCY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(SimpleAmount $simpleAmount, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $simpleAmount->setValue($data[self::KEY_VALUE]);
    }
}
