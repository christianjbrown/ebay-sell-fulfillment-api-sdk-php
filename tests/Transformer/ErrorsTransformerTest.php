<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\ErrorInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ErrorsTransformer::class)]
final class ErrorsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(ErrorInterface::class);
        $second = self::createStub(ErrorInterface::class);

        $errorTransformer = self::createStub(ErrorTransformerInterface::class);
        $errorTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new ErrorsTransformer($errorTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new ErrorsTransformer(self::createStub(ErrorTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(ErrorsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ErrorsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', ErrorsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new ErrorsTransformer(self::createStub(ErrorTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
