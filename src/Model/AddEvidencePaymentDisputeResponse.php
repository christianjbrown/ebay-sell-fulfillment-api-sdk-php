<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class AddEvidencePaymentDisputeResponse implements AddEvidencePaymentDisputeResponseInterface
{
    private ?string $evidenceId = null;

    public function getEvidenceId(): ?string
    {
        return $this->evidenceId;
    }

    public function setEvidenceId(?string $value): AddEvidencePaymentDisputeResponseInterface
    {
        $this->evidenceId = $value;

        return $this;
    }
}
