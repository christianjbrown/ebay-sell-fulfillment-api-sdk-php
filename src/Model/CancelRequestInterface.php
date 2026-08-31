<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface CancelRequestInterface
{
    public function getCancelCompletedDate(): ?string;

    public function getCancelInitiator(): ?string;

    public function getCancelReason(): ?string;

    public function getCancelRequestedDate(): ?string;

    public function getCancelRequestId(): ?string;

    public function getCancelRequestState(): ?string;

    public function setCancelCompletedDate(?string $value): self;

    public function setCancelInitiator(?string $value): self;

    public function setCancelReason(?string $value): self;

    public function setCancelRequestedDate(?string $value): self;

    public function setCancelRequestId(?string $value): self;

    public function setCancelRequestState(?string $value): self;
}
