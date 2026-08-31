<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentHoldInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class PaymentHoldsTransformer implements PaymentHoldsTransformerInterface
{
    private PaymentHoldTransformerInterface $paymentHoldTransformer;

    public function __construct(PaymentHoldTransformerInterface $paymentHoldTransformer)
    {
        $this->paymentHoldTransformer = $paymentHoldTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentHoldInterface>
     */
    public function transform(array $data): array
    {
        $paymentHolds = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $paymentHolds[] = $this->paymentHoldTransformer->transform($value);
        }

        return $paymentHolds;
    }
}
