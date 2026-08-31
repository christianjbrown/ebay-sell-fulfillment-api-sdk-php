<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayVaultProgram;
use ChristianBrown\EBay\SellFulfillment\Model\EbayVaultProgramInterface;

use function is_string;

final class EbayVaultProgramTransformer implements EbayVaultProgramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayVaultProgramInterface
    {
        $ebayVaultProgram = new EbayVaultProgram();

        self::applyFulfillmentType($ebayVaultProgram, $data);

        return $ebayVaultProgram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFulfillmentType(EbayVaultProgram $ebayVaultProgram, array $data): void
    {
        if (empty($data[self::KEY_FULFILLMENT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_FULFILLMENT_TYPE])) {
            return;
        }
        $ebayVaultProgram->setFulfillmentType($data[self::KEY_FULFILLMENT_TYPE]);
    }
}
