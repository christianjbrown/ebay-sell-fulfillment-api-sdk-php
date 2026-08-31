<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PaymentHoldInterface
{
    public function getExpectedReleaseDate(): ?string;

    public function getHoldAmount(): ?AmountInterface;

    public function getHoldReason(): ?string;

    public function getHoldState(): ?string;

    public function getReleaseDate(): ?string;

    /**
     * @return array<int, SellerActionToReleaseInterface>
     */
    public function getSellerActionsToRelease(): array;

    public function setExpectedReleaseDate(?string $value): self;

    public function setHoldAmount(?AmountInterface $value): self;

    public function setHoldReason(?string $value): self;

    public function setHoldState(?string $value): self;

    public function setReleaseDate(?string $value): self;

    /**
     * @param array<int, SellerActionToReleaseInterface> $value
     */
    public function setSellerActionsToRelease(array $value): self;
}
