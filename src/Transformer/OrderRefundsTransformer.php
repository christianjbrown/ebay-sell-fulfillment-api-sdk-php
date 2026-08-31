<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\OrderRefundInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class OrderRefundsTransformer implements OrderRefundsTransformerInterface
{
    private OrderRefundTransformerInterface $orderRefundTransformer;

    public function __construct(OrderRefundTransformerInterface $orderRefundTransformer)
    {
        $this->orderRefundTransformer = $orderRefundTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrderRefundInterface>
     */
    public function transform(array $data): array
    {
        $orderRefunds = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $orderRefunds[] = $this->orderRefundTransformer->transform($value);
        }

        return $orderRefunds;
    }
}
