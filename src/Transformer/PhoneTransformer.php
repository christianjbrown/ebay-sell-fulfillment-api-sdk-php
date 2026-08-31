<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Phone;
use ChristianBrown\EBay\SellFulfillment\Model\PhoneInterface;

use function is_string;

final class PhoneTransformer implements PhoneTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PhoneInterface
    {
        $phone = new Phone();

        self::applyCountryCode($phone, $data);
        self::applyNumber($phone, $data);

        return $phone;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryCode(Phone $phone, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        $phone->setCountryCode($data[self::KEY_COUNTRY_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNumber(Phone $phone, array $data): void
    {
        if (empty($data[self::KEY_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_NUMBER])) {
            return;
        }
        $phone->setNumber($data[self::KEY_NUMBER]);
    }
}
