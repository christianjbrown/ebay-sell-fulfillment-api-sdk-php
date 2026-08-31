<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class PostSaleAuthenticationProgram implements PostSaleAuthenticationProgramInterface
{
    private ?string $outcomeReason = null;
    private ?string $status = null;

    public function getOutcomeReason(): ?string
    {
        return $this->outcomeReason;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setOutcomeReason(?string $value): PostSaleAuthenticationProgramInterface
    {
        $this->outcomeReason = $value;

        return $this;
    }

    public function setStatus(?string $value): PostSaleAuthenticationProgramInterface
    {
        $this->status = $value;

        return $this;
    }
}
