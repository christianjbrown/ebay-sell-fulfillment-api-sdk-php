<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface AddEvidencePaymentDisputeRequestInterface
{
    public function getEvidenceType(): ?string;

    /**
     * @return array<int, FileEvidenceInterface>
     */
    public function getFiles(): array;

    /**
     * @return array<int, OrderLineItemInterface>
     */
    public function getLineItems(): array;

    public function setEvidenceType(?string $value): self;

    /**
     * @param array<int, FileEvidenceInterface> $value
     */
    public function setFiles(array $value): self;

    /**
     * @param array<int, OrderLineItemInterface> $value
     */
    public function setLineItems(array $value): self;
}
