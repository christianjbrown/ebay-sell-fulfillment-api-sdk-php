<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface FileEvidenceInterface
{
    public function getFileId(): ?string;

    public function setFileId(?string $value): self;
}
