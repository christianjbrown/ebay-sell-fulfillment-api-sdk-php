<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface FileInfoInterface
{
    public function getFileId(): ?string;

    public function getFileType(): ?string;

    public function getName(): ?string;

    public function getUploadedDate(): ?string;

    public function setFileId(?string $value): self;

    public function setFileType(?string $value): self;

    public function setName(?string $value): self;

    public function setUploadedDate(?string $value): self;
}
