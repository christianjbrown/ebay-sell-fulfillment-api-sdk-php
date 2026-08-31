<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface PostSaleAuthenticationProgramInterface
{
    public function getOutcomeReason(): ?string;

    public function getStatus(): ?string;

    public function setOutcomeReason(?string $value): self;

    public function setStatus(?string $value): self;
}
