<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelRequestInterface;

interface CancelRequestTransformerInterface
{
    public const string KEY_CANCEL_COMPLETED_DATE = 'cancelCompletedDate';
    public const string KEY_CANCEL_INITIATOR = 'cancelInitiator';
    public const string KEY_CANCEL_REASON = 'cancelReason';
    public const string KEY_CANCEL_REQUEST_ID = 'cancelRequestId';
    public const string KEY_CANCEL_REQUEST_STATE = 'cancelRequestState';
    public const string KEY_CANCEL_REQUESTED_DATE = 'cancelRequestedDate';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CancelRequestInterface;
}
