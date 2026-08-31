<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class InfoFromBuyer implements InfoFromBuyerInterface
{
    private ?string $note = null;

    /**
     * @var array<int, TrackingInfoInterface>
     */
    private array $returnShipmentTracking = [];

    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @return array<int, TrackingInfoInterface>
     */
    public function getReturnShipmentTracking(): array
    {
        return $this->returnShipmentTracking;
    }

    public function setNote(?string $value): InfoFromBuyerInterface
    {
        $this->note = $value;

        return $this;
    }

    /**
     * @param array<int, TrackingInfoInterface> $value
     */
    public function setReturnShipmentTracking(array $value): InfoFromBuyerInterface
    {
        $this->returnShipmentTracking = $value;

        return $this;
    }
}
