<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentInterface;

use function array_values;
use function count;

final class PaymentsTransformer implements PaymentsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private PaymentTransformerInterface $paymentTransformer;

    public function __construct(PaymentTransformerInterface $paymentTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->paymentTransformer = $paymentTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
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
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $payments[] = $this->paymentTransformer->transform($value);
        }

        return $payments;
    }
}
