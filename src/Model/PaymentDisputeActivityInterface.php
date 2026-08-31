<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentDisputeActivityInterface
{
    public function getActivityDate(): ?string;

    public function getActivityType(): ?string;

    public function getActor(): ?string;

    public function setActivityDate(?string $value): self;

    public function setActivityType(?string $value): self;

    public function setActor(?string $value): self;
}
