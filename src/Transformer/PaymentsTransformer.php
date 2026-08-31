<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class PaymentsTransformer implements PaymentsTransformerInterface
{
    private PaymentTransformerInterface $paymentTransformer;

    public function __construct(PaymentTransformerInterface $paymentTransformer)
    {
        $this->paymentTransformer = $paymentTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentInterface>
     */
    public function transform(array $data): array
    {
        $payments = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $payments[] = $this->paymentTransformer->transform($value);
        }

        return $payments;
    }
}
