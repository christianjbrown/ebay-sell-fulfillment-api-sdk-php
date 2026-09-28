<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrderLineItemsTransformer::class)]
final class OrderLineItemsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(OrderLineItemInterface::class);
        $second = self::createStub(OrderLineItemInterface::class);

        $orderLineItemTransformer = self::createStub(OrderLineItemTransformerInterface::class);
        $orderLineItemTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new OrderLineItemsTransformer($orderLineItemTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new OrderLineItemsTransformer(self::createStub(OrderLineItemTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(OrderLineItemsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrderLineItemsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', OrderLineItemsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new OrderLineItemsTransformer(self::createStub(OrderLineItemTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
