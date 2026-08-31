<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\SimpleAmountInterface;

final class SimpleAmountSerializer implements SimpleAmountSerializerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(SimpleAmountInterface $simpleAmount): array
    {
        $data = [];

        $data = self::applyCurrency($data, $simpleAmount);
        $data = self::applyValue($data, $simpleAmount);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyCurrency(array $data, SimpleAmountInterface $simpleAmount): array
    {
        $value = $simpleAmount->getCurrency();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_CURRENCY] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyValue(array $data, SimpleAmountInterface $simpleAmount): array
    {
        $value = $simpleAmount->getValue();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_VALUE] = $value;

        return $data;
    }
}
