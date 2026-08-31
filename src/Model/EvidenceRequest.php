<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EvidenceRequest implements EvidenceRequestInterface
{
    private ?string $evidenceId = null;
    private ?string $evidenceType = null;

    /**
     * @var array<int, OrderLineItemInterface>
     */
    private array $lineItems = [];
    private ?string $requestDate = null;
    private ?string $respondByDate = null;

    public function getEvidenceId(): ?string
    {
        return $this->evidenceId;
    }

    public function getEvidenceType(): ?string
    {
        return $this->evidenceType;
    }

    /**
     * @return array<int, OrderLineItemInterface>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    public function getRespondByDate(): ?string
    {
        return $this->respondByDate;
    }

    public function setEvidenceId(?string $value): EvidenceRequestInterface
    {
        $this->evidenceId = $value;

        return $this;
    }

    public function setEvidenceType(?string $value): EvidenceRequestInterface
    {
        $this->evidenceType = $value;

        return $this;
    }

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): EvidenceRequestInterface
    {
        $this->lineItems = $value;

        return $this;
    }

    public function setRequestDate(?string $value): EvidenceRequestInterface
    {
        $this->requestDate = $value;

        return $this;
    }

    public function setRespondByDate(?string $value): EvidenceRequestInterface
    {
        $this->respondByDate = $value;

        return $this;
    }
}
