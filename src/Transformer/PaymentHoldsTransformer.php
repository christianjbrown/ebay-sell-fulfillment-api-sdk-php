<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentHoldInterface;

use function array_values;
use function count;

final class PaymentHoldsTransformer implements PaymentHoldsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private PaymentHoldTransformerInterface $paymentHoldTransformer;

    public function __construct(PaymentHoldTransformerInterface $paymentHoldTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->paymentHoldTransformer = $paymentHoldTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
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
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $paymentHolds[] = $this->paymentHoldTransformer->transform($value);
        }

        return $paymentHolds;
    }
}
