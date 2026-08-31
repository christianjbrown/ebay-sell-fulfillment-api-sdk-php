<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileInfoInterface;

interface FileInfoTransformerInterface
{
    public const string KEY_FILE_ID = 'fileId';
    public const string KEY_FILE_TYPE = 'fileType';
    public const string KEY_NAME = 'name';
    public const string KEY_UPLOADED_DATE = 'uploadedDate';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): FileInfoInterface;
}
