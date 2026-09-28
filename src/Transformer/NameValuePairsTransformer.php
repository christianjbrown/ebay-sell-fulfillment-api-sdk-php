<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\NameValuePairInterface;

use function array_values;
use function count;

final class NameValuePairsTransformer implements NameValuePairsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private NameValuePairTransformerInterface $nameValuePairTransformer;

    public function __construct(NameValuePairTransformerInterface $nameValuePairTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->nameValuePairTransformer = $nameValuePairTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, NameValuePairInterface>
     */
    public function transform(array $data): array
    {
        $nameValuePairs = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $nameValuePairs[] = $this->nameValuePairTransformer->transform($value);
        }

        return $nameValuePairs;
    }
}
