<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItemInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class LinkedOrderLineItemsTransformer implements LinkedOrderLineItemsTransformerInterface
{
    private LinkedOrderLineItemTransformerInterface $linkedOrderLineItemTransformer;

    public function __construct(LinkedOrderLineItemTransformerInterface $linkedOrderLineItemTransformer)
    {
        $this->linkedOrderLineItemTransformer = $linkedOrderLineItemTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LinkedOrderLineItemInterface>
     */
    public function transform(array $data): array
    {
        $linkedOrderLineItems = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $linkedOrderLineItems[] = $this->linkedOrderLineItemTransformer->transform($value);
        }

        return $linkedOrderLineItems;
    }
}
