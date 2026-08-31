<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Http;

use ChristianBrown\EBay\SellFulfillment\Http\MultipartFormDataBuilder;
use ChristianBrown\EBay\SellFulfillment\Http\MultipartFormDataBuilderInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function mb_strlen;
use function sprintf;

#[CoversClass(MultipartFormDataBuilder::class)]
final class MultipartFormDataBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $builder = new MultipartFormDataBuilder();

        $expected = "--test-boundary\r\n"
        ."Content-Disposition: form-data; name=\"file\"; filename=\"evidence.png\"\r\n"
        ."Content-Type: image/png\r\n"
        ."\r\n"
        ."binary-bytes\r\n"
        ."--test-boundary--\r\n";

        self::assertSame($expected, $builder->build('test-boundary', 'file', 'evidence.png', 'image/png', 'binary-bytes'));
    }

    public function testGenerateBoundaryIsPrefixedAndUnique(): void
    {
        $builder = new MultipartFormDataBuilder();

        $boundary = $builder->generateBoundary();

        self::assertStringStartsWith(sprintf(MultipartFormDataBuilderInterface::BOUNDARY_SPRINTF, ''), $boundary);
        self::assertSame(mb_strlen(sprintf(MultipartFormDataBuilderInterface::BOUNDARY_SPRINTF, '')) + (MultipartFormDataBuilderInterface::BOUNDARY_BYTES * 2), mb_strlen($boundary));
        self::assertNotSame($boundary, $builder->generateBoundary());
    }

    public function testToContentTypeHeaderValue(): void
    {
        $builder = new MultipartFormDataBuilder();

        self::assertSame('multipart/form-data; boundary=test-boundary', $builder->toContentTypeHeaderValue('test-boundary'));
    }
}
