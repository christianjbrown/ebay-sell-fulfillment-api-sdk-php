<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LinkedOrderLineItemsTransformer::class)]
final class LinkedOrderLineItemsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(LinkedOrderLineItemInterface::class);
        $second = self::createStub(LinkedOrderLineItemInterface::class);

        $linkedOrderLineItemTransformer = self::createStub(LinkedOrderLineItemTransformerInterface::class);
        $linkedOrderLineItemTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new LinkedOrderLineItemsTransformer($linkedOrderLineItemTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new LinkedOrderLineItemsTransformer(self::createStub(LinkedOrderLineItemTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new LinkedOrderLineItemsTransformer(self::createStub(LinkedOrderLineItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LinkedOrderLineItemsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LinkedOrderLineItemsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
