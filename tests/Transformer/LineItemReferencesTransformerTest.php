<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferencesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferencesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LineItemReferencesTransformer::class)]
final class LineItemReferencesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(LineItemReferenceInterface::class);
        $second = self::createStub(LineItemReferenceInterface::class);

        $lineItemReferenceTransformer = self::createStub(LineItemReferenceTransformerInterface::class);
        $lineItemReferenceTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new LineItemReferencesTransformer($lineItemReferenceTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new LineItemReferencesTransformer(self::createStub(LineItemReferenceTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new LineItemReferencesTransformer(self::createStub(LineItemReferenceTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LineItemReferencesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LineItemReferencesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
