<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface InfoFromBuyerInterface
{
    public function getNote(): ?string;

    /**
     * @return array<int, TrackingInfoInterface>
     */
    public function getReturnShipmentTracking(): array;

    public function setNote(?string $value): self;

    /**
     * @param array<int, TrackingInfoInterface> $value
     */
    public function setReturnShipmentTracking(array $value): self;
}
