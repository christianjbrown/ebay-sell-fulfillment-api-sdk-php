<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefundInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LineItemRefundsTransformer::class)]
final class LineItemRefundsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(LineItemRefundInterface::class);
        $second = self::createStub(LineItemRefundInterface::class);

        $lineItemRefundTransformer = self::createStub(LineItemRefundTransformerInterface::class);
        $lineItemRefundTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new LineItemRefundsTransformer($lineItemRefundTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new LineItemRefundsTransformer(self::createStub(LineItemRefundTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(LineItemRefundsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LineItemRefundsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', LineItemRefundsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new LineItemRefundsTransformer(self::createStub(LineItemRefundTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
