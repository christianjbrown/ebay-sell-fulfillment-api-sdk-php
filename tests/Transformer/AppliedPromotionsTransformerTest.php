<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AppliedPromotionsTransformer::class)]
final class AppliedPromotionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(AppliedPromotionInterface::class);
        $second = self::createStub(AppliedPromotionInterface::class);

        $appliedPromotionTransformer = self::createStub(AppliedPromotionTransformerInterface::class);
        $appliedPromotionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new AppliedPromotionsTransformer($appliedPromotionTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new AppliedPromotionsTransformer(self::createStub(AppliedPromotionTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(AppliedPromotionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AppliedPromotionsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', AppliedPromotionsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new AppliedPromotionsTransformer(self::createStub(AppliedPromotionTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
