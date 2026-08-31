<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface LineItemReferenceInterface
{
    public function getLineItemId(): ?string;

    public function getQuantity(): ?int;

    public function setLineItemId(?string $value): self;

    public function setQuantity(?int $value): self;
}
