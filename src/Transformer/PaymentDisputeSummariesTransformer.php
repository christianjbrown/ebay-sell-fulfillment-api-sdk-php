<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummaryInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class PaymentDisputeSummariesTransformer implements PaymentDisputeSummariesTransformerInterface
{
    private PaymentDisputeSummaryTransformerInterface $paymentDisputeSummaryTransformer;

    public function __construct(PaymentDisputeSummaryTransformerInterface $paymentDisputeSummaryTransformer)
    {
        $this->paymentDisputeSummaryTransformer = $paymentDisputeSummaryTransformer;
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
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $paymentDisputeSummaries[] = $this->paymentDisputeSummaryTransformer->transform($value);
        }

        return $paymentDisputeSummaries;
    }
}
