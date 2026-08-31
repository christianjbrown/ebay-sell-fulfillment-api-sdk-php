<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentDisputeActivityHistoryInterface
{
    /**
     * @return array<int, PaymentDisputeActivityInterface>
     */
    public function getActivity(): array;

    /**
     * @param array<int, PaymentDisputeActivityInterface> $value
     */
    public function setActivity(array $value): self;
}
