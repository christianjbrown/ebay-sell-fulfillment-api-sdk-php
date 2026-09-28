<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedCharges;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedChargesInterface;

use function is_array;

final class EbayCollectedChargesTransformer implements EbayCollectedChargesTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;
    private ?ChargesTransformerInterface $chargesTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer, ?ChargesTransformerInterface $chargesTransformer = null)
    {
        $this->amountTransformer = $amountTransformer;
        $this->chargesTransformer = $chargesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayCollectedChargesInterface
    {
        $ebayCollectedCharges = new EbayCollectedCharges();

        $this->applyCharges($ebayCollectedCharges, $data);
        $this->applyEbayShipping($ebayCollectedCharges, $data);

        return $ebayCollectedCharges;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCharges(EbayCollectedCharges $ebayCollectedCharges, array $data): void
    {
        if (null === $this->chargesTransformer) {
            return;
        }
        if (empty($data[self::KEY_CHARGES])) {
            return;
        }
        if (!is_array($data[self::KEY_CHARGES])) {
            return;
        }
        $ebayCollectedCharges->setCharges($this->chargesTransformer->transform($data[self::KEY_CHARGES]));
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
