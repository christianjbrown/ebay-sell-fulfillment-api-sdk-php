<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class LineItemReference implements LineItemReferenceInterface
{
    private ?string $lineItemId = null;
    private ?int $quantity = null;

    public function getLineItemId(): ?string
    {
        return $this->lineItemId;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setLineItemId(?string $value): LineItemReferenceInterface
    {
        $this->lineItemId = $value;

        return $this;
    }

    public function setQuantity(?int $value): LineItemReferenceInterface
    {
        $this->quantity = $value;

        return $this;
    }
}
