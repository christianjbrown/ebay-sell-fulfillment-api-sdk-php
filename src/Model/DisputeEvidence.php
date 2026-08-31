<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class DisputeEvidence implements DisputeEvidenceInterface
{
    private ?string $evidenceId = null;
    private ?string $evidenceType = null;

    /**
     * @var array<int, FileInfoInterface>
     */
    private array $files = [];

    /**
     * @var array<int, OrderLineItemInterface>
     */
    private array $lineItems = [];
    private ?string $providedDate = null;
    private ?string $requestDate = null;
    private ?string $respondByDate = null;

    /**
     * @var array<int, TrackingInfoInterface>
     */
    private array $shipmentTracking = [];

    public function getEvidenceId(): ?string
    {
        return $this->evidenceId;
    }

    public function getEvidenceType(): ?string
    {
        return $this->evidenceType;
    }

    /**
     * @return array<int, FileInfoInterface>
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

    public function getProvidedDate(): ?string
    {
        return $this->providedDate;
    }

    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    public function getRespondByDate(): ?string
    {
        return $this->respondByDate;
    }

    /**
     * @return array<int, TrackingInfoInterface>
     */
    public function getShipmentTracking(): array
    {
        return $this->shipmentTracking;
    }

    public function setEvidenceId(?string $value): DisputeEvidenceInterface
    {
        $this->evidenceId = $value;

        return $this;
    }

    public function setEvidenceType(?string $value): DisputeEvidenceInterface
    {
        $this->evidenceType = $value;

        return $this;
    }

    /**
     * @param array<int, FileInfoInterface> $value
     */
    public function setFiles(array $value): DisputeEvidenceInterface
    {
        $this->files = $value;

        return $this;
    }

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): DisputeEvidenceInterface
    {
        $this->lineItems = $value;

        return $this;
    }

    public function setProvidedDate(?string $value): DisputeEvidenceInterface
    {
        $this->providedDate = $value;

        return $this;
    }

    public function setRequestDate(?string $value): DisputeEvidenceInterface
    {
        $this->requestDate = $value;

        return $this;
    }

    public function setRespondByDate(?string $value): DisputeEvidenceInterface
    {
        $this->respondByDate = $value;

        return $this;
    }

    /**
     * @param array<int, TrackingInfoInterface> $value
     */
    public function setShipmentTracking(array $value): DisputeEvidenceInterface
    {
        $this->shipmentTracking = $value;

        return $this;
    }
}
