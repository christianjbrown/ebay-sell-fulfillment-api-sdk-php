<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionTransformerInterface;
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

        $transformer = new AppliedPromotionsTransformer($appliedPromotionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new AppliedPromotionsTransformer(self::createStub(AppliedPromotionTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new AppliedPromotionsTransformer(self::createStub(AppliedPromotionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AppliedPromotionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AppliedPromotionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
