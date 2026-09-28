<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummaryInterface;

use function array_values;
use function count;

final class PaymentDisputeSummariesTransformer implements PaymentDisputeSummariesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private PaymentDisputeSummaryTransformerInterface $paymentDisputeSummaryTransformer;

    public function __construct(PaymentDisputeSummaryTransformerInterface $paymentDisputeSummaryTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->paymentDisputeSummaryTransformer = $paymentDisputeSummaryTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PaymentDisputeSummaryInterface>
     */
    public function transform(array $data): array
    {
        $paymentDisputeSummaries = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $paymentDisputeSummaries[] = $this->paymentDisputeSummaryTransformer->transform($value);
        }

        return $paymentDisputeSummaries;
    }
}
