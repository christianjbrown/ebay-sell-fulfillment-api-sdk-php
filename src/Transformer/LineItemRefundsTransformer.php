<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefundInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class LineItemRefundsTransformer implements LineItemRefundsTransformerInterface
{
    private LineItemRefundTransformerInterface $lineItemRefundTransformer;

    public function __construct(LineItemRefundTransformerInterface $lineItemRefundTransformer)
    {
        $this->lineItemRefundTransformer = $lineItemRefundTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LineItemRefundInterface>
     */
    public function transform(array $data): array
    {
        $lineItemRefunds = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $lineItemRefunds[] = $this->lineItemRefundTransformer->transform($value);
        }

        return $lineItemRefunds;
    }
}
