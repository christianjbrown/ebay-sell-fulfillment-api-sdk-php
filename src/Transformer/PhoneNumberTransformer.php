<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneNumber;
use ChristianBrown\EBay\SellFulfillment\Model\PhoneNumberInterface;

use function is_string;

final class PhoneNumberTransformer implements PhoneNumberTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PhoneNumberInterface
    {
        $phoneNumber = new PhoneNumber();

        self::applyPhoneNumber($phoneNumber, $data);

        return $phoneNumber;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPhoneNumber(PhoneNumber $phoneNumber, array $data): void
    {
        if (empty($data[self::KEY_PHONE_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_PHONE_NUMBER])) {
            return;
        }
        $phoneNumber->setPhoneNumber($data[self::KEY_PHONE_NUMBER]);
    }
}
