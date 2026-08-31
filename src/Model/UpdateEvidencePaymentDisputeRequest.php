<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class UpdateEvidencePaymentDisputeRequest implements UpdateEvidencePaymentDisputeRequestInterface
{
    private ?string $evidenceId = null;
    private ?string $evidenceType = null;

    /**
     * @var array<int, FileEvidenceInterface>
     */
    private array $files = [];

    /**
     * @var array<int, OrderLineItemInterface>
     */
    private array $lineItems = [];

    public function getEvidenceId(): ?string
    {
        return $this->evidenceId;
    }

    public function getEvidenceType(): ?string
    {
        return $this->evidenceType;
    }

    /**
     * @return array<int, FileEvidenceInterface>
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return array<int, OrderLineItemInterface>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    public function setEvidenceId(?string $value): UpdateEvidencePaymentDisputeRequestInterface
    {
        $this->evidenceId = $value;

        return $this;
    }

    public function setEvidenceType(?string $value): UpdateEvidencePaymentDisputeRequestInterface
    {
        $this->evidenceType = $value;

        return $this;
    }

    /**
     * @param array<int, FileEvidenceInterface> $value
     */
    public function setFiles(array $value): UpdateEvidencePaymentDisputeRequestInterface
    {
        $this->files = $value;

        return $this;
    }

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): UpdateEvidencePaymentDisputeRequestInterface
    {
        $this->lineItems = $value;

        return $this;
    }
}
