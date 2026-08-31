<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface DisputeEvidenceInterface
{
    public function getEvidenceId(): ?string;

    public function getEvidenceType(): ?string;

    /**
     * @return array<int, FileInfoInterface>
     */
    public function getFiles(): array;

    /**
     * @return array<int, OrderLineItemInterface>
     */
    public function getLineItems(): array;

    public function getProvidedDate(): ?string;

    public function getRequestDate(): ?string;

    public function getRespondByDate(): ?string;

    /**
     * @return array<int, TrackingInfoInterface>
     */
    public function getShipmentTracking(): array;

    public function setEvidenceId(?string $value): self;

    public function setEvidenceType(?string $value): self;

    /**
     * @param array<int, FileInfoInterface> $value
     */
    public function setFiles(array $value): self;

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): self;

    public function setProvidedDate(?string $value): self;

    public function setRequestDate(?string $value): self;

    public function setRespondByDate(?string $value): self;

    /**
     * @param array<int, TrackingInfoInterface> $value
     */
    public function setShipmentTracking(array $value): self;
}
