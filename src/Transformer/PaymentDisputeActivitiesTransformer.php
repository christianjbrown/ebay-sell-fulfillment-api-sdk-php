<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityInterface;

use function array_values;
use function count;

final class PaymentDisputeActivitiesTransformer implements PaymentDisputeActivitiesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private PaymentDisputeActivityTransformerInterface $paymentDisputeActivityTransformer;

    public function __construct(PaymentDisputeActivityTransformerInterface $paymentDisputeActivityTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->paymentDisputeActivityTransformer = $paymentDisputeActivityTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
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
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $paymentDisputeActivities[] = $this->paymentDisputeActivityTransformer->transform($value);
        }

        return $paymentDisputeActivities;
    }
}
