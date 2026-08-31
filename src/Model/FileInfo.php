<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class FileInfo implements FileInfoInterface
{
    private ?string $fileId = null;
    private ?string $fileType = null;
    private ?string $name = null;
    private ?string $uploadedDate = null;

    public function getFileId(): ?string
    {
        return $this->fileId;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUploadedDate(): ?string
    {
        return $this->uploadedDate;
    }

    public function setFileId(?string $value): FileInfoInterface
    {
        $this->fileId = $value;

        return $this;
    }

    public function setFileType(?string $value): FileInfoInterface
    {
        $this->fileType = $value;

        return $this;
    }

    public function setName(?string $value): FileInfoInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setUploadedDate(?string $value): FileInfoInterface
    {
        $this->uploadedDate = $value;

        return $this;
    }
}
