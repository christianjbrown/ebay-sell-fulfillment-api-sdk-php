<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class CancelRequest implements CancelRequestInterface
{
    private ?string $cancelCompletedDate = null;
    private ?string $cancelInitiator = null;
    private ?string $cancelReason = null;
    private ?string $cancelRequestedDate = null;
    private ?string $cancelRequestId = null;
    private ?string $cancelRequestState = null;

    public function getCancelCompletedDate(): ?string
    {
        return $this->cancelCompletedDate;
    }

    public function getCancelInitiator(): ?string
    {
        return $this->cancelInitiator;
    }

    public function getCancelReason(): ?string
    {
        return $this->cancelReason;
    }

    public function getCancelRequestedDate(): ?string
    {
        return $this->cancelRequestedDate;
    }

    public function getCancelRequestId(): ?string
    {
        return $this->cancelRequestId;
    }

    public function getCancelRequestState(): ?string
    {
        return $this->cancelRequestState;
    }

    public function setCancelCompletedDate(?string $value): CancelRequestInterface
    {
        $this->cancelCompletedDate = $value;

        return $this;
    }

    public function setCancelInitiator(?string $value): CancelRequestInterface
    {
        $this->cancelInitiator = $value;

        return $this;
    }

    public function setCancelReason(?string $value): CancelRequestInterface
    {
        $this->cancelReason = $value;

        return $this;
    }

    public function setCancelRequestedDate(?string $value): CancelRequestInterface
    {
        $this->cancelRequestedDate = $value;

        return $this;
    }

    public function setCancelRequestId(?string $value): CancelRequestInterface
    {
        $this->cancelRequestId = $value;

        return $this;
    }

    public function setCancelRequestState(?string $value): CancelRequestInterface
    {
        $this->cancelRequestState = $value;

        return $this;
    }
}
