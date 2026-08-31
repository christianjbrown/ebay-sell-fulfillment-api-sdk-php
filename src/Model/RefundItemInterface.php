<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface RefundItemInterface
{
    public function getLegacyReference(): ?LegacyReferenceInterface;

    public function getLineItemId(): ?string;

    public function getRefundAmount(): ?SimpleAmountInterface;

    public function setLegacyReference(?LegacyReferenceInterface $value): self;

    public function setLineItemId(?string $value): self;

    public function setRefundAmount(?SimpleAmountInterface $value): self;
}
