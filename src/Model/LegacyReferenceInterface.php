<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface LegacyReferenceInterface
{
    public function getLegacyItemId(): ?string;

    public function getLegacyTransactionId(): ?string;

    public function setLegacyItemId(?string $value): self;

    public function setLegacyTransactionId(?string $value): self;
}
