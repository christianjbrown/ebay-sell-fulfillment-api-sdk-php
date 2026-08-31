<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;

final class FileEvidenceSerializer implements FileEvidenceSerializerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(FileEvidenceInterface $fileEvidence): array
    {
        $data = [];

        $data = self::applyFileId($data, $fileEvidence);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyFileId(array $data, FileEvidenceInterface $fileEvidence): array
    {
        $value = $fileEvidence->getFileId();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_FILE_ID] = $value;

        return $data;
    }
}
