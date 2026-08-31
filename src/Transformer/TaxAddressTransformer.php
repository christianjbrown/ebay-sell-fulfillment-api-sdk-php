<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxAddress;
use ChristianBrown\EBay\SellFulfillment\Model\TaxAddressInterface;

use function is_string;

final class TaxAddressTransformer implements TaxAddressTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxAddressInterface
    {
        $taxAddress = new TaxAddress();

        self::applyCity($taxAddress, $data);
        self::applyCountryCode($taxAddress, $data);
        self::applyPostalCode($taxAddress, $data);
        self::applyStateOrProvince($taxAddress, $data);

        return $taxAddress;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(TaxAddress $taxAddress, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $taxAddress->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryCode(TaxAddress $taxAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        $taxAddress->setCountryCode($data[self::KEY_COUNTRY_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(TaxAddress $taxAddress, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $taxAddress->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(TaxAddress $taxAddress, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $taxAddress->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }
}
