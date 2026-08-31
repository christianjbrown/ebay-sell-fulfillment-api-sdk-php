<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PaymentHold implements PaymentHoldInterface
{
    private ?string $expectedReleaseDate = null;
    private ?AmountInterface $holdAmount = null;
    private ?string $holdReason = null;
    private ?string $holdState = null;
    private ?string $releaseDate = null;

    /**
     * @var array<int, SellerActionToReleaseInterface>
     */
    private array $sellerActionsToRelease = [];

    public function getExpectedReleaseDate(): ?string
    {
        return $this->expectedReleaseDate;
    }

    public function getHoldAmount(): ?AmountInterface
    {
        return $this->holdAmount;
    }

    public function getHoldReason(): ?string
    {
        return $this->holdReason;
    }

    public function getHoldState(): ?string
    {
        return $this->holdState;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    /**
     * @return array<int, SellerActionToReleaseInterface>
     */
    public function getSellerActionsToRelease(): array
    {
        return $this->sellerActionsToRelease;
    }

    public function setExpectedReleaseDate(?string $value): PaymentHoldInterface
    {
        $this->expectedReleaseDate = $value;

        return $this;
    }

    public function setHoldAmount(?AmountInterface $value): PaymentHoldInterface
    {
        $this->holdAmount = $value;

        return $this;
    }

    public function setHoldReason(?string $value): PaymentHoldInterface
    {
        $this->holdReason = $value;

        return $this;
    }

    public function setHoldState(?string $value): PaymentHoldInterface
    {
        $this->holdState = $value;

        return $this;
    }

    public function setReleaseDate(?string $value): PaymentHoldInterface
    {
        $this->releaseDate = $value;

        return $this;
    }

    /**
     * @param array<int, SellerActionToReleaseInterface> $value
     */
    public function setSellerActionsToRelease(array $value): PaymentHoldInterface
    {
        $this->sellerActionsToRelease = $value;

        return $this;
    }
}
