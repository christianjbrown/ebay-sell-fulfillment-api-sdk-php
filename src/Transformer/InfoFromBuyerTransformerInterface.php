<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\InfoFromBuyerInterface;

interface InfoFromBuyerTransformerInterface
{
    public const string KEY_CONTENT_ON_HOLD = 'contentOnHold';
    public const string KEY_NOTE = 'note';
    public const string KEY_RETURN_SHIPMENT_TRACKING = 'returnShipmentTracking';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InfoFromBuyerInterface;
}
