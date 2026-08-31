<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayFulfillmentProgram;
use ChristianBrown\EBay\SellFulfillment\Model\EbayFulfillmentProgramInterface;

use function is_string;

final class EbayFulfillmentProgramTransformer implements EbayFulfillmentProgramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EbayFulfillmentProgramInterface
    {
        $ebayFulfillmentProgram = new EbayFulfillmentProgram();

        self::applyFulfilledBy($ebayFulfillmentProgram, $data);

        return $ebayFulfillmentProgram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFulfilledBy(EbayFulfillmentProgram $ebayFulfillmentProgram, array $data): void
    {
        if (empty($data[self::KEY_FULFILLED_BY])) {
            return;
        }
        if (!is_string($data[self::KEY_FULFILLED_BY])) {
            return;
        }
        $ebayFulfillmentProgram->setFulfilledBy($data[self::KEY_FULFILLED_BY]);
    }
}
