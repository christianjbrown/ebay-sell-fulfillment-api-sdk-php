<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_string;
use function sprintf;

final class StringsTransformer implements StringsTransformerInterface
{
    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    public function transform(array $data): array
    {
        $strings = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_string($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $strings[] = $value;
        }

        return $strings;
    }
}
