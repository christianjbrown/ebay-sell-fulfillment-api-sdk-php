<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentHold;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentHoldInterface;

use function is_array;
use function is_string;

final class PaymentHoldTransformer implements PaymentHoldTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;
    private SellerActionsToReleaseTransformerInterface $sellerActionsToReleaseTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer, SellerActionsToReleaseTransformerInterface $sellerActionsToReleaseTransformer)
    {
        $this->amountTransformer = $amountTransformer;
        $this->sellerActionsToReleaseTransformer = $sellerActionsToReleaseTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentHoldInterface
    {
        $paymentHold = new PaymentHold();

        self::applyExpectedReleaseDate($paymentHold, $data);
        $this->applyHoldAmount($paymentHold, $data);
        self::applyHoldReason($paymentHold, $data);
        self::applyHoldState($paymentHold, $data);
        self::applyReleaseDate($paymentHold, $data);
        $this->applySellerActionsToRelease($paymentHold, $data);

        return $paymentHold;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExpectedReleaseDate(PaymentHold $paymentHold, array $data): void
    {
        if (empty($data[self::KEY_EXPECTED_RELEASE_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_EXPECTED_RELEASE_DATE])) {
            return;
        }
        $paymentHold->setExpectedReleaseDate($data[self::KEY_EXPECTED_RELEASE_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHoldAmount(PaymentHold $paymentHold, array $data): void
    {
        if (empty($data[self::KEY_HOLD_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_HOLD_AMOUNT])) {
            return;
        }
        $paymentHold->setHoldAmount($this->amountTransformer->transform($data[self::KEY_HOLD_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHoldReason(PaymentHold $paymentHold, array $data): void
    {
        if (empty($data[self::KEY_HOLD_REASON])) {
            return;
        }
        if (!is_string($data[self::KEY_HOLD_REASON])) {
            return;
        }
        $paymentHold->setHoldReason($data[self::KEY_HOLD_REASON]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHoldState(PaymentHold $paymentHold, array $data): void
    {
        if (empty($data[self::KEY_HOLD_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_HOLD_STATE])) {
            return;
        }
        $paymentHold->setHoldState($data[self::KEY_HOLD_STATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReleaseDate(PaymentHold $paymentHold, array $data): void
    {
        if (empty($data[self::KEY_RELEASE_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_RELEASE_DATE])) {
            return;
        }
        $paymentHold->setReleaseDate($data[self::KEY_RELEASE_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySellerActionsToRelease(PaymentHold $paymentHold, array $data): void
    {
        if (empty($data[self::KEY_SELLER_ACTIONS_TO_RELEASE])) {
            return;
        }
        if (!is_array($data[self::KEY_SELLER_ACTIONS_TO_RELEASE])) {
            return;
        }
        $paymentHold->setSellerActionsToRelease($this->sellerActionsToReleaseTransformer->transform($data[self::KEY_SELLER_ACTIONS_TO_RELEASE]));
    }
}
