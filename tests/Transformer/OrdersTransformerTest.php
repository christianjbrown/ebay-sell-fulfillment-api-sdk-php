<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrdersTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrdersTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrdersTransformer::class)]
final class OrdersTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(OrderInterface::class);
        $second = self::createStub(OrderInterface::class);

        $orderTransformer = self::createStub(OrderTransformerInterface::class);
        $orderTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new OrdersTransformer($orderTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new OrdersTransformer(self::createStub(OrderTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new OrdersTransformer(self::createStub(OrderTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrdersTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrdersTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
