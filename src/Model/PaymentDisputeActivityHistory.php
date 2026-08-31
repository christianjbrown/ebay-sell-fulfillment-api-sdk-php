<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PaymentDisputeActivityHistory implements PaymentDisputeActivityHistoryInterface
{
    /**
     * @var array<int, PaymentDisputeActivityInterface>
     */
    private array $activity = [];

    /**
     * @return array<int, PaymentDisputeActivityInterface>
     */
    public function getActivity(): array
    {
        return $this->activity;
    }

    /**
     * @param array<int, PaymentDisputeActivityInterface> $value
     */
    public function setActivity(array $value): PaymentDisputeActivityHistoryInterface
    {
        $this->activity = $value;

        return $this;
    }
}
