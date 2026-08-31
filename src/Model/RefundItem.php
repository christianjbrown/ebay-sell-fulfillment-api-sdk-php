<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class RefundItem implements RefundItemInterface
{
    private ?LegacyReferenceInterface $legacyReference = null;
    private ?string $lineItemId = null;
    private ?SimpleAmountInterface $refundAmount = null;

    public function getLegacyReference(): ?LegacyReferenceInterface
    {
        return $this->legacyReference;
    }

    public function getLineItemId(): ?string
    {
        return $this->lineItemId;
    }

    public function getRefundAmount(): ?SimpleAmountInterface
    {
        return $this->refundAmount;
    }

    public function setLegacyReference(?LegacyReferenceInterface $value): RefundItemInterface
    {
        $this->legacyReference = $value;

        return $this;
    }

    public function setLineItemId(?string $value): RefundItemInterface
    {
        $this->lineItemId = $value;

        return $this;
    }

    public function setRefundAmount(?SimpleAmountInterface $value): RefundItemInterface
    {
        $this->refundAmount = $value;

        return $this;
    }
}
