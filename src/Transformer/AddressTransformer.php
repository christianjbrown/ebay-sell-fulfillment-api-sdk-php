<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Address;
use ChristianBrown\EBay\SellFulfillment\Model\AddressInterface;

use function is_string;

final class AddressTransformer implements AddressTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AddressInterface
    {
        $address = new Address();

        self::applyAddressLine1($address, $data);
        self::applyAddressLine2($address, $data);
        self::applyCity($address, $data);
        self::applyCountryCode($address, $data);
        self::applyCounty($address, $data);
        self::applyPostalCode($address, $data);
        self::applyStateOrProvince($address, $data);

        return $address;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine1(Address $address, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        $address->setAddressLine1($data[self::KEY_ADDRESS_LINE1]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine2(Address $address, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        $address->setAddressLine2($data[self::KEY_ADDRESS_LINE2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(Address $address, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $address->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryCode(Address $address, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        $address->setCountryCode($data[self::KEY_COUNTRY_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCounty(Address $address, array $data): void
    {
        if (empty($data[self::KEY_COUNTY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTY])) {
            return;
        }
        $address->setCounty($data[self::KEY_COUNTY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(Address $address, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $address->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(Address $address, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $address->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }
}
