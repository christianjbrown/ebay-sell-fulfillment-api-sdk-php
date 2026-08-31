<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ExtendedContact;
use ChristianBrown\EBay\SellFulfillment\Model\ExtendedContactInterface;

use function is_array;
use function is_string;

final class ExtendedContactTransformer implements ExtendedContactTransformerInterface
{
    private AddressTransformerInterface $addressTransformer;
    private PhoneNumberTransformerInterface $phoneNumberTransformer;

    public function __construct(AddressTransformerInterface $addressTransformer, PhoneNumberTransformerInterface $phoneNumberTransformer)
    {
        $this->addressTransformer = $addressTransformer;
        $this->phoneNumberTransformer = $phoneNumberTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExtendedContactInterface
    {
        $extendedContact = new ExtendedContact();

        self::applyCompanyName($extendedContact, $data);
        $this->applyContactAddress($extendedContact, $data);
        self::applyEmail($extendedContact, $data);
        self::applyFullName($extendedContact, $data);
        $this->applyPrimaryPhone($extendedContact, $data);

        return $extendedContact;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCompanyName(ExtendedContact $extendedContact, array $data): void
    {
        if (empty($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        $extendedContact->setCompanyName($data[self::KEY_COMPANY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyContactAddress(ExtendedContact $extendedContact, array $data): void
    {
        if (empty($data[self::KEY_CONTACT_ADDRESS])) {
            return;
        }
        if (!is_array($data[self::KEY_CONTACT_ADDRESS])) {
            return;
        }
        $extendedContact->setContactAddress($this->addressTransformer->transform($data[self::KEY_CONTACT_ADDRESS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEmail(ExtendedContact $extendedContact, array $data): void
    {
        if (empty($data[self::KEY_EMAIL])) {
            return;
        }
        if (!is_string($data[self::KEY_EMAIL])) {
            return;
        }
        $extendedContact->setEmail($data[self::KEY_EMAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFullName(ExtendedContact $extendedContact, array $data): void
    {
        if (empty($data[self::KEY_FULL_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_FULL_NAME])) {
            return;
        }
        $extendedContact->setFullName($data[self::KEY_FULL_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrimaryPhone(ExtendedContact $extendedContact, array $data): void
    {
        if (empty($data[self::KEY_PRIMARY_PHONE])) {
            return;
        }
        if (!is_array($data[self::KEY_PRIMARY_PHONE])) {
            return;
        }
        $extendedContact->setPrimaryPhone($this->phoneNumberTransformer->transform($data[self::KEY_PRIMARY_PHONE]));
    }
}
