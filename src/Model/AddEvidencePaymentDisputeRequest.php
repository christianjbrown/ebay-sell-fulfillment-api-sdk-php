<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class AddEvidencePaymentDisputeRequest implements AddEvidencePaymentDisputeRequestInterface
{
    private ?string $evidenceType = null;

    /**
     * @var array<int, FileEvidenceInterface>
     */
    private array $files = [];

    /**
     * @var array<int, OrderLineItemInterface>
     */
    private array $lineItems = [];

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

    public function setEvidenceType(?string $value): AddEvidencePaymentDisputeRequestInterface
    {
        $this->evidenceType = $value;

        return $this;
    }

    /**
     * @param array<int, FileEvidenceInterface> $value
     */
    public function setFiles(array $value): AddEvidencePaymentDisputeRequestInterface
    {
        $this->files = $value;

        return $this;
    }

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): AddEvidencePaymentDisputeRequestInterface
    {
        $this->lineItems = $value;

        return $this;
    }
}
