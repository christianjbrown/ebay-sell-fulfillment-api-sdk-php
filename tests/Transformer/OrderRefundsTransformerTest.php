<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\OrderRefundInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrderRefundsTransformer::class)]
final class OrderRefundsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(OrderRefundInterface::class);
        $second = self::createStub(OrderRefundInterface::class);

        $orderRefundTransformer = self::createStub(OrderRefundTransformerInterface::class);
        $orderRefundTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new OrderRefundsTransformer($orderRefundTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new OrderRefundsTransformer(self::createStub(OrderRefundTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(OrderRefundsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrderRefundsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', OrderRefundsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new OrderRefundsTransformer(self::createStub(OrderRefundTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
