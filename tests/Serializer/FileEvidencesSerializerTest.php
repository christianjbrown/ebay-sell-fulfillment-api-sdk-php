<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidenceSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidencesSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileEvidencesSerializer::class)]
final class FileEvidencesSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $first = self::createStub(FileEvidenceInterface::class);
        $second = self::createStub(FileEvidenceInterface::class);

        $fileEvidenceSerializer = self::createStub(FileEvidenceSerializerInterface::class);
        $fileEvidenceSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$first, ['first' => 'test-1']],
                    [$second, ['second' => 'test-2']],
                ]
            );

        $serializer = new FileEvidencesSerializer($fileEvidenceSerializer);

        self::assertSame([['first' => 'test-1'], ['second' => 'test-2']], $serializer->serialize([$first, $second]));
    }

    public function testSerializeEmpty(): void
    {
        $serializer = new FileEvidencesSerializer(self::createStub(FileEvidenceSerializerInterface::class));

        self::assertSame([], $serializer->serialize([]));
    }
}
