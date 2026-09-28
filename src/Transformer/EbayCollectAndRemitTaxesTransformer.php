<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTaxInterface;

use function array_values;
use function count;

final class EbayCollectAndRemitTaxesTransformer implements EbayCollectAndRemitTaxesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private EbayCollectAndRemitTaxTransformerInterface $ebayCollectAndRemitTaxTransformer;

    public function __construct(EbayCollectAndRemitTaxTransformerInterface $ebayCollectAndRemitTaxTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->ebayCollectAndRemitTaxTransformer = $ebayCollectAndRemitTaxTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
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
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $ebayCollectAndRemitTaxes[] = $this->ebayCollectAndRemitTaxTransformer->transform($value);
        }

        return $ebayCollectAndRemitTaxes;
    }
}
