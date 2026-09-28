<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\InfoFromBuyer;
use ChristianBrown\EBay\SellFulfillment\Model\InfoFromBuyerInterface;

use function is_array;
use function is_bool;
use function is_string;

final class InfoFromBuyerTransformer implements InfoFromBuyerTransformerInterface
{
    private TrackingInfosTransformerInterface $trackingInfosTransformer;

    public function __construct(TrackingInfosTransformerInterface $trackingInfosTransformer)
    {
        $this->trackingInfosTransformer = $trackingInfosTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InfoFromBuyerInterface
    {
        $infoFromBuyer = new InfoFromBuyer();

        self::applyContentOnHold($infoFromBuyer, $data);
        self::applyNote($infoFromBuyer, $data);
        $this->applyReturnShipmentTracking($infoFromBuyer, $data);

        return $infoFromBuyer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyContentOnHold(InfoFromBuyer $infoFromBuyer, array $data): void
    {
        if (!isset($data[self::KEY_CONTENT_ON_HOLD])) {
            return;
        }
        if (!is_bool($data[self::KEY_CONTENT_ON_HOLD])) {
            return;
        }
        $infoFromBuyer->setContentOnHold($data[self::KEY_CONTENT_ON_HOLD]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNote(InfoFromBuyer $infoFromBuyer, array $data): void
    {
        if (empty($data[self::KEY_NOTE])) {
            return;
        }
        if (!is_string($data[self::KEY_NOTE])) {
            return;
        }
        $infoFromBuyer->setNote($data[self::KEY_NOTE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyReturnShipmentTracking(InfoFromBuyer $infoFromBuyer, array $data): void
    {
        if (empty($data[self::KEY_RETURN_SHIPMENT_TRACKING])) {
            return;
        }
        if (!is_array($data[self::KEY_RETURN_SHIPMENT_TRACKING])) {
            return;
        }
        $infoFromBuyer->setReturnShipmentTracking($this->trackingInfosTransformer->transform($data[self::KEY_RETURN_SHIPMENT_TRACKING]));
    }
}
