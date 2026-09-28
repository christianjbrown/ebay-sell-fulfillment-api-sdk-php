<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameterInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParametersTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParameterTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ErrorParametersTransformer::class)]
final class ErrorParametersTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(ErrorParameterInterface::class);
        $second = self::createStub(ErrorParameterInterface::class);

        $errorParameterTransformer = self::createStub(ErrorParameterTransformerInterface::class);
        $errorParameterTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new ErrorParametersTransformer($errorParameterTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new ErrorParametersTransformer(self::createStub(ErrorParameterTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(ErrorParametersTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ErrorParametersTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', ErrorParametersTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new ErrorParametersTransformer(self::createStub(ErrorParameterTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
