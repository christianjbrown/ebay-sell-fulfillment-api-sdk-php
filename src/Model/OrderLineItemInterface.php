<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface OrderLineItemInterface
{
    public function getItemId(): ?string;

    public function getLineItemId(): ?string;

    public function setItemId(?string $value): self;

    public function setLineItemId(?string $value): self;
}
