<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface CancelStatusInterface
{
    public function getCancelledDate(): ?string;

    /**
     * @return array<int, CancelRequestInterface>
     */
    public function getCancelRequests(): array;

    public function getCancelState(): ?string;

    public function setCancelledDate(?string $value): self;

    /**
     * @param array<int, CancelRequestInterface> $value
     */
    public function setCancelRequests(array $value): self;

    public function setCancelState(?string $value): self;
}
