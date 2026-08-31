<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ItemLocation;
use ChristianBrown\EBay\SellFulfillment\Model\ItemLocationInterface;

use function is_string;

final class ItemLocationTransformer implements ItemLocationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemLocationInterface
    {
        $itemLocation = new ItemLocation();

        self::applyCountryCode($itemLocation, $data);
        self::applyLocation($itemLocation, $data);
        self::applyPostalCode($itemLocation, $data);

        return $itemLocation;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryCode(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        $itemLocation->setCountryCode($data[self::KEY_COUNTRY_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocation(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_LOCATION])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION])) {
            return;
        }
        $itemLocation->setLocation($data[self::KEY_LOCATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $itemLocation->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }
}
