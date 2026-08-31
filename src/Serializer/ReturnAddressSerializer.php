<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddressInterface;

final class ReturnAddressSerializer implements ReturnAddressSerializerInterface
{
    private PhoneSerializerInterface $phoneSerializer;

    public function __construct(PhoneSerializerInterface $phoneSerializer)
    {
        $this->phoneSerializer = $phoneSerializer;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(ReturnAddressInterface $returnAddress): array
    {
        $data = [];

        $data = self::applyAddressLine1($data, $returnAddress);
        $data = self::applyAddressLine2($data, $returnAddress);
        $data = self::applyCity($data, $returnAddress);
        $data = self::applyCountry($data, $returnAddress);
        $data = self::applyCounty($data, $returnAddress);
        $data = self::applyFullName($data, $returnAddress);
        $data = self::applyPostalCode($data, $returnAddress);
        $data = $this->applyPrimaryPhone($data, $returnAddress);
        $data = self::applyStateOrProvince($data, $returnAddress);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyAddressLine1(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getAddressLine1();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_ADDRESS_LINE1] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyAddressLine2(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getAddressLine2();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_ADDRESS_LINE2] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyCity(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getCity();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_CITY] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyCountry(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getCountry();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_COUNTRY] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyCounty(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getCounty();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_COUNTY] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyFullName(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getFullName();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_FULL_NAME] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyPostalCode(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getPostalCode();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_POSTAL_CODE] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyPrimaryPhone(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getPrimaryPhone();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_PRIMARY_PHONE] = $this->phoneSerializer->serialize($value);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyStateOrProvince(array $data, ReturnAddressInterface $returnAddress): array
    {
        $value = $returnAddress->getStateOrProvince();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_STATE_OR_PROVINCE] = $value;

        return $data;
    }
}
