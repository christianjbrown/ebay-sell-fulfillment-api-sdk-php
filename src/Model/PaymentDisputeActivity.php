<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PaymentDisputeActivity implements PaymentDisputeActivityInterface
{
    private ?string $activityDate = null;
    private ?string $activityType = null;
    private ?string $actor = null;

    public function getActivityDate(): ?string
    {
        return $this->activityDate;
    }

    public function getActivityType(): ?string
    {
        return $this->activityType;
    }

    public function getActor(): ?string
    {
        return $this->actor;
    }

    public function setActivityDate(?string $value): PaymentDisputeActivityInterface
    {
        $this->activityDate = $value;

        return $this;
    }

    public function setActivityType(?string $value): PaymentDisputeActivityInterface
    {
        $this->activityType = $value;

        return $this;
    }

    public function setActor(?string $value): PaymentDisputeActivityInterface
    {
        $this->actor = $value;

        return $this;
    }
}
