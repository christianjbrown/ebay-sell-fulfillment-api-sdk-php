<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;

use function array_values;
use function count;

final class FileEvidencesSerializer implements FileEvidencesSerializerInterface
{
    private FileEvidenceSerializerInterface $fileEvidenceSerializer;

    public function __construct(FileEvidenceSerializerInterface $fileEvidenceSerializer)
    {
        $this->fileEvidenceSerializer = $fileEvidenceSerializer;
    }

    /**
     * @param array<int, FileEvidenceInterface> $fileEvidences
     *
     * @return array<int, array<string, mixed>>
     */
    public function serialize(array $fileEvidences): array
    {
        $data = [];
        $values = array_values($fileEvidences);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $data[] = $this->fileEvidenceSerializer->serialize($values[$i]);
        }

        return $data;
    }
}
