<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentHoldInterface;

interface PaymentHoldTransformerInterface
{
    public const string KEY_EXPECTED_RELEASE_DATE = 'expectedReleaseDate';
    public const string KEY_HOLD_AMOUNT = 'holdAmount';
    public const string KEY_HOLD_REASON = 'holdReason';
    public const string KEY_HOLD_STATE = 'holdState';
    public const string KEY_RELEASE_DATE = 'releaseDate';
    public const string KEY_SELLER_ACTIONS_TO_RELEASE = 'sellerActionsToRelease';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentHoldInterface;
}
