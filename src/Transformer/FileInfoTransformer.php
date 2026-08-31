<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileInfo;
use ChristianBrown\EBay\SellFulfillment\Model\FileInfoInterface;

use function is_string;

final class FileInfoTransformer implements FileInfoTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): FileInfoInterface
    {
        $fileInfo = new FileInfo();

        self::applyFileId($fileInfo, $data);
        self::applyFileType($fileInfo, $data);
        self::applyName($fileInfo, $data);
        self::applyUploadedDate($fileInfo, $data);

        return $fileInfo;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFileId(FileInfo $fileInfo, array $data): void
    {
        if (empty($data[self::KEY_FILE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_FILE_ID])) {
            return;
        }
        $fileInfo->setFileId($data[self::KEY_FILE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFileType(FileInfo $fileInfo, array $data): void
    {
        if (empty($data[self::KEY_FILE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_FILE_TYPE])) {
            return;
        }
        $fileInfo->setFileType($data[self::KEY_FILE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(FileInfo $fileInfo, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $fileInfo->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUploadedDate(FileInfo $fileInfo, array $data): void
    {
        if (empty($data[self::KEY_UPLOADED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_UPLOADED_DATE])) {
            return;
        }
        $fileInfo->setUploadedDate($data[self::KEY_UPLOADED_DATE]);
    }
}
