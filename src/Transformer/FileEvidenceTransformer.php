<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidence;
use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;

use function is_string;

final class FileEvidenceTransformer implements FileEvidenceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): FileEvidenceInterface
    {
        $fileEvidence = new FileEvidence();

        self::applyFileId($fileEvidence, $data);

        return $fileEvidence;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFileId(FileEvidence $fileEvidence, array $data): void
    {
        if (empty($data[self::KEY_FILE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_FILE_ID])) {
            return;
        }
        $fileEvidence->setFileId($data[self::KEY_FILE_ID]);
    }
}
