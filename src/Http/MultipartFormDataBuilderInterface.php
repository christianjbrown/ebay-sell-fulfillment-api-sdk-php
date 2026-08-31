<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Http;

use Random\RandomException;

interface MultipartFormDataBuilderInterface
{
    public const string BODY_SPRINTF = "--%s\r\nContent-Disposition: form-data; name=\"%s\"; filename=\"%s\"\r\nContent-Type: %s\r\n\r\n%s\r\n--%s--\r\n";
    public const int BOUNDARY_BYTES = 16;
    public const string BOUNDARY_SPRINTF = 'ChristianBrownEBaySellFulfillment%s';
    public const string CONTENT_TYPE_SPRINTF = 'multipart/form-data; boundary=%s';

    /**
     * Renders a `multipart/form-data` body holding exactly one file part, which
     * is all `uploadEvidenceFile` accepts.
     */
    public function build(string $boundary, string $fieldName, string $fileName, string $contentType, string $contents): string;

    /**
     * A fresh, random boundary token. Generated per request so it cannot collide
     * with the bytes of the file being uploaded.
     *
     * @throws RandomException
     */
    public function generateBoundary(): string;

    public function toContentTypeHeaderValue(string $boundary): string;
}
