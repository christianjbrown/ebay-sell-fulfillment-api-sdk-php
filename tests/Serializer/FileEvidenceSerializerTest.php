<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidence;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidenceSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileEvidence::class)]
#[CoversClass(FileEvidenceSerializer::class)]
final class FileEvidenceSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $fileEvidence = (new FileEvidence())
            ->setFileId('test-fileId');

        $serializer = new FileEvidenceSerializer();

        $expected = [
            FileEvidenceSerializerInterface::KEY_FILE_ID => 'test-fileId',
        ];

        self::assertSame($expected, $serializer->serialize($fileEvidence));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new FileEvidenceSerializer();

        self::assertSame([], $serializer->serialize(new FileEvidence()));
    }
}
