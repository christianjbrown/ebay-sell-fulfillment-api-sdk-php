<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileInfo;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfoTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfoTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileInfo::class)]
#[CoversClass(FileInfoTransformer::class)]
final class FileInfoTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            FileInfoTransformerInterface::KEY_FILE_ID => 'test-fileId',
            FileInfoTransformerInterface::KEY_FILE_TYPE => 'test-fileType',
            FileInfoTransformerInterface::KEY_NAME => 'test-name',
            FileInfoTransformerInterface::KEY_UPLOADED_DATE => 'test-uploadedDate',
        ];

        $transformer = new FileInfoTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-fileId', $actual->getFileId());
        self::assertSame('test-fileType', $actual->getFileType());
        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-uploadedDate', $actual->getUploadedDate());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedFileId, ?string $expectedFileType, ?string $expectedName, ?string $expectedUploadedDate): void
    {
        $transformer = new FileInfoTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedFileId, $actual->getFileId());
        self::assertSame($expectedFileType, $actual->getFileType());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedUploadedDate, $actual->getUploadedDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'fileIdWrongType' => [[FileInfoTransformerInterface::KEY_FILE_ID => 42], null, null, null, null];

        yield 'fileTypeWrongType' => [[FileInfoTransformerInterface::KEY_FILE_TYPE => 42], null, null, null, null];

        yield 'nameWrongType' => [[FileInfoTransformerInterface::KEY_NAME => 42], null, null, null, null];

        yield 'uploadedDateWrongType' => [[FileInfoTransformerInterface::KEY_UPLOADED_DATE => 42], null, null, null, null];
    }
}
