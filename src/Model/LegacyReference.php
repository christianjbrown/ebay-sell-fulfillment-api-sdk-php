<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class LegacyReference implements LegacyReferenceInterface
{
    private ?string $legacyItemId = null;
    private ?string $legacyTransactionId = null;

    public function getLegacyItemId(): ?string
    {
        return $this->legacyItemId;
    }

    public function getLegacyTransactionId(): ?string
    {
        return $this->legacyTransactionId;
    }

    public function setLegacyItemId(?string $value): LegacyReferenceInterface
    {
        $this->legacyItemId = $value;

        return $this;
    }

    public function setLegacyTransactionId(?string $value): LegacyReferenceInterface
    {
        $this->legacyTransactionId = $value;

        return $this;
    }
}
