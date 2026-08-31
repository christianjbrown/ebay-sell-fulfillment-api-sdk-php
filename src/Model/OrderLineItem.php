<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class OrderLineItem implements OrderLineItemInterface
{
    private ?string $itemId = null;
    private ?string $lineItemId = null;

    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    public function getLineItemId(): ?string
    {
        return $this->lineItemId;
    }

    public function setItemId(?string $value): OrderLineItemInterface
    {
        $this->itemId = $value;

        return $this;
    }

    public function setLineItemId(?string $value): OrderLineItemInterface
    {
        $this->lineItemId = $value;

        return $this;
    }
}
