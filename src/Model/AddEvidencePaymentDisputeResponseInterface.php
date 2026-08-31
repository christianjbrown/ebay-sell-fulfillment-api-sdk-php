<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface AddEvidencePaymentDisputeResponseInterface
{
    public function getEvidenceId(): ?string;

    public function setEvidenceId(?string $value): self;
}
