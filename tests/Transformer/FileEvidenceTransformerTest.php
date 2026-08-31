<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidence;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileEvidenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileEvidenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileEvidence::class)]
#[CoversClass(FileEvidenceTransformer::class)]
final class FileEvidenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            FileEvidenceTransformerInterface::KEY_FILE_ID => 'test-fileId',
        ];

        $transformer = new FileEvidenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-fileId', $actual->getFileId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedFileId): void
    {
        $transformer = new FileEvidenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedFileId, $actual->getFileId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'fileIdWrongType' => [[FileEvidenceTransformerInterface::KEY_FILE_ID => 42], null];
    }
}
