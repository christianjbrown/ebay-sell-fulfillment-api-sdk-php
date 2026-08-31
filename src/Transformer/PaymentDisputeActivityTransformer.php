<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivity;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityInterface;

use function is_string;

final class PaymentDisputeActivityTransformer implements PaymentDisputeActivityTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeActivityInterface
    {
        $paymentDisputeActivity = new PaymentDisputeActivity();

        self::applyActivityDate($paymentDisputeActivity, $data);
        self::applyActivityType($paymentDisputeActivity, $data);
        self::applyActor($paymentDisputeActivity, $data);

        return $paymentDisputeActivity;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActivityDate(PaymentDisputeActivity $paymentDisputeActivity, array $data): void
    {
        if (empty($data[self::KEY_ACTIVITY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTIVITY_DATE])) {
            return;
        }
        $paymentDisputeActivity->setActivityDate($data[self::KEY_ACTIVITY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActivityType(PaymentDisputeActivity $paymentDisputeActivity, array $data): void
    {
        if (empty($data[self::KEY_ACTIVITY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTIVITY_TYPE])) {
            return;
        }
        $paymentDisputeActivity->setActivityType($data[self::KEY_ACTIVITY_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActor(PaymentDisputeActivity $paymentDisputeActivity, array $data): void
    {
        if (empty($data[self::KEY_ACTOR])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTOR])) {
            return;
        }
        $paymentDisputeActivity->setActor($data[self::KEY_ACTOR]);
    }
}
