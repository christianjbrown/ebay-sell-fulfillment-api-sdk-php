<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class LineItemsTransformer implements LineItemsTransformerInterface
{
    private LineItemTransformerInterface $lineItemTransformer;

    public function __construct(LineItemTransformerInterface $lineItemTransformer)
    {
        $this->lineItemTransformer = $lineItemTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LineItemInterface>
     */
    public function transform(array $data): array
    {
        $lineItems = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $lineItems[] = $this->lineItemTransformer->transform($value);
        }

        return $lineItems;
    }
}
