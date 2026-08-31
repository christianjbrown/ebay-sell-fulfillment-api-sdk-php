<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneInterface;

final class PhoneSerializer implements PhoneSerializerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(PhoneInterface $phone): array
    {
        $data = [];

        $data = self::applyCountryCode($data, $phone);
        $data = self::applyNumber($data, $phone);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyCountryCode(array $data, PhoneInterface $phone): array
    {
        $value = $phone->getCountryCode();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_COUNTRY_CODE] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyNumber(array $data, PhoneInterface $phone): array
    {
        $value = $phone->getNumber();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_NUMBER] = $value;

        return $data;
    }
}
