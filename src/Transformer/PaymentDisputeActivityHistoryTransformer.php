<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityHistory;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityHistoryInterface;

use function is_array;

final class PaymentDisputeActivityHistoryTransformer implements PaymentDisputeActivityHistoryTransformerInterface
{
    private PaymentDisputeActivitiesTransformerInterface $paymentDisputeActivitiesTransformer;

    public function __construct(PaymentDisputeActivitiesTransformerInterface $paymentDisputeActivitiesTransformer)
    {
        $this->paymentDisputeActivitiesTransformer = $paymentDisputeActivitiesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeActivityHistoryInterface
    {
        $paymentDisputeActivityHistory = new PaymentDisputeActivityHistory();

        $this->applyActivity($paymentDisputeActivityHistory, $data);

        return $paymentDisputeActivityHistory;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActivity(PaymentDisputeActivityHistory $paymentDisputeActivityHistory, array $data): void
    {
        if (empty($data[self::KEY_ACTIVITY])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIVITY])) {
            return;
        }
        $paymentDisputeActivityHistory->setActivity($this->paymentDisputeActivitiesTransformer->transform($data[self::KEY_ACTIVITY]));
    }
}
