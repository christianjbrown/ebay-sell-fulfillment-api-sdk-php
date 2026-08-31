<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;

interface FileEvidencesSerializerInterface
{
    /**
     * @param array<int, FileEvidenceInterface> $fileEvidences
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $fileEvidences): array;
}
