<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\NameValuePairInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class NameValuePairsTransformer implements NameValuePairsTransformerInterface
{
    private NameValuePairTransformerInterface $nameValuePairTransformer;

    public function __construct(NameValuePairTransformerInterface $nameValuePairTransformer)
    {
        $this->nameValuePairTransformer = $nameValuePairTransformer;
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
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $nameValuePairs[] = $this->nameValuePairTransformer->transform($value);
        }

        return $nameValuePairs;
    }
}
