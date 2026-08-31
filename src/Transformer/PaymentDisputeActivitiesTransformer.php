<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class PaymentDisputeActivitiesTransformer implements PaymentDisputeActivitiesTransformerInterface
{
    private PaymentDisputeActivityTransformerInterface $paymentDisputeActivityTransformer;

    public function __construct(PaymentDisputeActivityTransformerInterface $paymentDisputeActivityTransformer)
    {
        $this->paymentDisputeActivityTransformer = $paymentDisputeActivityTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentDisputeActivityInterface>
     */
    public function transform(array $data): array
    {
        $paymentDisputeActivities = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $paymentDisputeActivities[] = $this->paymentDisputeActivityTransformer->transform($value);
        }

        return $paymentDisputeActivities;
    }
}
