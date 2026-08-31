<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class CancelStatus implements CancelStatusInterface
{
    private ?string $cancelledDate = null;

    /**
     * @var array<int, CancelRequestInterface>
     */
    private array $cancelRequests = [];
    private ?string $cancelState = null;

    public function getCancelledDate(): ?string
    {
        return $this->cancelledDate;
    }

    /**
     * @return array<int, CancelRequestInterface>
     */
    public function getCancelRequests(): array
    {
        return $this->cancelRequests;
    }

    public function getCancelState(): ?string
    {
        return $this->cancelState;
    }

    public function setCancelledDate(?string $value): CancelStatusInterface
    {
        $this->cancelledDate = $value;

        return $this;
    }

    /**
     * @param array<int, CancelRequestInterface> $value
     */
    public function setCancelRequests(array $value): CancelStatusInterface
    {
        $this->cancelRequests = $value;

        return $this;
    }

    public function setCancelState(?string $value): CancelStatusInterface
    {
        $this->cancelState = $value;

        return $this;
    }
}
