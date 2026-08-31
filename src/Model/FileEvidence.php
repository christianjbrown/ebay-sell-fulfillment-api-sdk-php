<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class FileEvidence implements FileEvidenceInterface
{
    private ?string $fileId = null;

    public function getFileId(): ?string
    {
        return $this->fileId;
    }

    public function setFileId(?string $value): FileEvidenceInterface
    {
        $this->fileId = $value;

        return $this;
    }
}
