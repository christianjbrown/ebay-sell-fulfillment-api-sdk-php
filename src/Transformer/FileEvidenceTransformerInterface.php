<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;

interface FileEvidenceTransformerInterface
{
    public const string KEY_FILE_ID = 'fileId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): FileEvidenceInterface;
}
