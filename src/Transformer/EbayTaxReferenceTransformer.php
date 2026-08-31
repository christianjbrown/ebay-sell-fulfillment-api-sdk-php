<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayTaxReference;
use ChristianBrown\EBay\SellFulfillment\Model\EbayTaxReferenceInterface;

use function is_string;

final class EbayTaxReferenceTransformer implements EbayTaxReferenceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayTaxReferenceInterface
    {
        $ebayTaxReference = new EbayTaxReference();

        self::applyName($ebayTaxReference, $data);
        self::applyValue($ebayTaxReference, $data);

        return $ebayTaxReference;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(EbayTaxReference $ebayTaxReference, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $ebayTaxReference->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(EbayTaxReference $ebayTaxReference, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $ebayTaxReference->setValue($data[self::KEY_VALUE]);
    }
}
