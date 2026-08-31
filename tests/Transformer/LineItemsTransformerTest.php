<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LineItemsTransformer::class)]
final class LineItemsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(LineItemInterface::class);
        $second = self::createStub(LineItemInterface::class);

        $lineItemTransformer = self::createStub(LineItemTransformerInterface::class);
        $lineItemTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new LineItemsTransformer($lineItemTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new LineItemsTransformer(self::createStub(LineItemTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new LineItemsTransformer(self::createStub(LineItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LineItemsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LineItemsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
