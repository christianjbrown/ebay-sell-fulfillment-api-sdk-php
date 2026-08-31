<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelStatusInterface;

interface CancelStatusTransformerInterface
{
    public const string KEY_CANCEL_REQUESTS = 'cancelRequests';
    public const string KEY_CANCEL_STATE = 'cancelState';
    public const string KEY_CANCELLED_DATE = 'cancelledDate';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CancelStatusInterface;
}
