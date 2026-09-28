<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\ChargeInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ChargesTransformer::class)]
final class ChargesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(ChargeInterface::class);
        $second = self::createStub(ChargeInterface::class);

        $chargeTransformer = self::createStub(ChargeTransformerInterface::class);
        $chargeTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new ChargesTransformer($chargeTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new ChargesTransformer(self::createStub(ChargeTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(ChargesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ChargesTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', ChargesTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new ChargesTransformer(self::createStub(ChargeTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
