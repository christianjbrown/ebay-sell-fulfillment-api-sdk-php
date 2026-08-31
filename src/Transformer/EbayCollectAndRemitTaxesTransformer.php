<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTaxInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class EbayCollectAndRemitTaxesTransformer implements EbayCollectAndRemitTaxesTransformerInterface
{
    private EbayCollectAndRemitTaxTransformerInterface $ebayCollectAndRemitTaxTransformer;

    public function __construct(EbayCollectAndRemitTaxTransformerInterface $ebayCollectAndRemitTaxTransformer)
    {
        $this->ebayCollectAndRemitTaxTransformer = $ebayCollectAndRemitTaxTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, EbayCollectAndRemitTaxInterface>
     */
    public function transform(array $data): array
    {
        $ebayCollectAndRemitTaxes = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $ebayCollectAndRemitTaxes[] = $this->ebayCollectAndRemitTaxTransformer->transform($value);
        }

        return $ebayCollectAndRemitTaxes;
    }
}
