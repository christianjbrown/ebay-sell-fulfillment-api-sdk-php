<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;

interface FileEvidenceSerializerInterface
{
    public const string KEY_FILE_ID = 'fileId';

    /**
     * @return array<string, mixed>
     */
    public function serialize(FileEvidenceInterface $fileEvidence): array;
}
