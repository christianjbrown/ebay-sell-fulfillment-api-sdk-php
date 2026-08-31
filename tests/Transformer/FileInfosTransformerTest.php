<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\FileInfoInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfosTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfosTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfoTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(FileInfosTransformer::class)]
final class FileInfosTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(FileInfoInterface::class);
        $second = self::createStub(FileInfoInterface::class);

        $fileInfoTransformer = self::createStub(FileInfoTransformerInterface::class);
        $fileInfoTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new FileInfosTransformer($fileInfoTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new FileInfosTransformer(self::createStub(FileInfoTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new FileInfosTransformer(self::createStub(FileInfoTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(FileInfosTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, FileInfosTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
