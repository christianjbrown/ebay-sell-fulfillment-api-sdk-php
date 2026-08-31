<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTax;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTaxInterface;

use function is_array;
use function is_string;

final class EbayCollectAndRemitTaxTransformer implements EbayCollectAndRemitTaxTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;
    private EbayTaxReferenceTransformerInterface $ebayTaxReferenceTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer, EbayTaxReferenceTransformerInterface $ebayTaxReferenceTransformer)
    {
        $this->amountTransformer = $amountTransformer;
        $this->ebayTaxReferenceTransformer = $ebayTaxReferenceTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayCollectAndRemitTaxInterface
    {
        $ebayCollectAndRemitTax = new EbayCollectAndRemitTax();

        $this->applyAmount($ebayCollectAndRemitTax, $data);
        self::applyCollectionMethod($ebayCollectAndRemitTax, $data);
        $this->applyEbayReference($ebayCollectAndRemitTax, $data);
        self::applyTaxType($ebayCollectAndRemitTax, $data);

        return $ebayCollectAndRemitTax;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(EbayCollectAndRemitTax $ebayCollectAndRemitTax, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $ebayCollectAndRemitTax->setAmount($this->amountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCollectionMethod(EbayCollectAndRemitTax $ebayCollectAndRemitTax, array $data): void
    {
        if (empty($data[self::KEY_COLLECTION_METHOD])) {
            return;
        }
        if (!is_string($data[self::KEY_COLLECTION_METHOD])) {
            return;
        }
        $ebayCollectAndRemitTax->setCollectionMethod($data[self::KEY_COLLECTION_METHOD]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEbayReference(EbayCollectAndRemitTax $ebayCollectAndRemitTax, array $data): void
    {
        if (empty($data[self::KEY_EBAY_REFERENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_EBAY_REFERENCE])) {
            return;
        }
        $ebayCollectAndRemitTax->setEbayReference($this->ebayTaxReferenceTransformer->transform($data[self::KEY_EBAY_REFERENCE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTaxType(EbayCollectAndRemitTax $ebayCollectAndRemitTax, array $data): void
    {
        if (empty($data[self::KEY_TAX_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TAX_TYPE])) {
            return;
        }
        $ebayCollectAndRemitTax->setTaxType($data[self::KEY_TAX_TYPE]);
    }
}
