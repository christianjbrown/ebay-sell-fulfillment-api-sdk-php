<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Http;

use Random\RandomException;

use function bin2hex;
use function random_bytes;
use function sprintf;

final class MultipartFormDataBuilder implements MultipartFormDataBuilderInterface
{
    public function build(string $boundary, string $fieldName, string $fileName, string $contentType, string $contents): string
    {
        return sprintf(self::BODY_SPRINTF, $boundary, $fieldName, $fileName, $contentType, $contents, $boundary);
    }

    /**
     * @throws RandomException
     */
    public function generateBoundary(): string
    {
        return sprintf(self::BOUNDARY_SPRINTF, bin2hex(random_bytes(self::BOUNDARY_BYTES)));
    }

    public function toContentTypeHeaderValue(string $boundary): string
    {
        return sprintf(self::CONTENT_TYPE_SPRINTF, $boundary);
    }
}
