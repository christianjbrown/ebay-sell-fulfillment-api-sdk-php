<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxIdentifier;
use ChristianBrown\EBay\SellFulfillment\Model\TaxIdentifierInterface;

use function is_string;

final class TaxIdentifierTransformer implements TaxIdentifierTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxIdentifierInterface
    {
        $taxIdentifier = new TaxIdentifier();

        self::applyIssuingCountry($taxIdentifier, $data);
        self::applyTaxIdentifierType($taxIdentifier, $data);
        self::applyTaxpayerId($taxIdentifier, $data);

        return $taxIdentifier;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIssuingCountry(TaxIdentifier $taxIdentifier, array $data): void
    {
        if (empty($data[self::KEY_ISSUING_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_ISSUING_COUNTRY])) {
            return;
        }
        $taxIdentifier->setIssuingCountry($data[self::KEY_ISSUING_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTaxIdentifierType(TaxIdentifier $taxIdentifier, array $data): void
    {
        if (empty($data[self::KEY_TAX_IDENTIFIER_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TAX_IDENTIFIER_TYPE])) {
            return;
        }
        $taxIdentifier->setTaxIdentifierType($data[self::KEY_TAX_IDENTIFIER_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTaxpayerId(TaxIdentifier $taxIdentifier, array $data): void
    {
        if (empty($data[self::KEY_TAXPAYER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TAXPAYER_ID])) {
            return;
        }
        $taxIdentifier->setTaxpayerId($data[self::KEY_TAXPAYER_ID]);
    }
}
