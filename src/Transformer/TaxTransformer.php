<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Tax;
use ChristianBrown\EBay\SellFulfillment\Model\TaxInterface;

use function is_array;
use function is_string;

final class TaxTransformer implements TaxTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TaxInterface
    {
        $tax = new Tax();

        $this->applyAmount($tax, $data);
        self::applyTaxType($tax, $data);

        return $tax;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(Tax $tax, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $tax->setAmount($this->amountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTaxType(Tax $tax, array $data): void
    {
        if (empty($data[self::KEY_TAX_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TAX_TYPE])) {
            return;
        }
        $tax->setTaxType($data[self::KEY_TAX_TYPE]);
    }
}
