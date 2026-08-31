<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddress;
use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddressInterface;

use function is_array;
use function is_string;

final class ReturnAddressTransformer implements ReturnAddressTransformerInterface
{
    private PhoneTransformerInterface $phoneTransformer;

    public function __construct(PhoneTransformerInterface $phoneTransformer)
    {
        $this->phoneTransformer = $phoneTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReturnAddressInterface
    {
        $returnAddress = new ReturnAddress();

        self::applyAddressLine1($returnAddress, $data);
        self::applyAddressLine2($returnAddress, $data);
        self::applyCity($returnAddress, $data);
        self::applyCountry($returnAddress, $data);
        self::applyCounty($returnAddress, $data);
        self::applyFullName($returnAddress, $data);
        self::applyPostalCode($returnAddress, $data);
        $this->applyPrimaryPhone($returnAddress, $data);
        self::applyStateOrProvince($returnAddress, $data);

        return $returnAddress;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine1(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        $returnAddress->setAddressLine1($data[self::KEY_ADDRESS_LINE1]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine2(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        $returnAddress->setAddressLine2($data[self::KEY_ADDRESS_LINE2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $returnAddress->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountry(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            return;
        }
        $returnAddress->setCountry($data[self::KEY_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCounty(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTY])) {
            return;
        }
        $returnAddress->setCounty($data[self::KEY_COUNTY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFullName(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_FULL_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_FULL_NAME])) {
            return;
        }
        $returnAddress->setFullName($data[self::KEY_FULL_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $returnAddress->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrimaryPhone(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_PRIMARY_PHONE])) {
            return;
        }
        if (!is_array($data[self::KEY_PRIMARY_PHONE])) {
            return;
        }
        $returnAddress->setPrimaryPhone($this->phoneTransformer->transform($data[self::KEY_PRIMARY_PHONE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(ReturnAddress $returnAddress, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $returnAddress->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }
}
