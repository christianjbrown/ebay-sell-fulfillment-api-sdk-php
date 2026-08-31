<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedCharges;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedChargesInterface;

use function is_array;

final class EbayCollectedChargesTransformer implements EbayCollectedChargesTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayCollectedChargesInterface
    {
        $ebayCollectedCharges = new EbayCollectedCharges();

        $this->applyEbayShipping($ebayCollectedCharges, $data);

        return $ebayCollectedCharges;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEbayShipping(EbayCollectedCharges $ebayCollectedCharges, array $data): void
    {
        if (empty($data[self::KEY_EBAY_SHIPPING])) {
            return;
        }
        if (!is_array($data[self::KEY_EBAY_SHIPPING])) {
            return;
        }
        $ebayCollectedCharges->setEbayShipping($this->amountTransformer->transform($data[self::KEY_EBAY_SHIPPING]));
    }
}
