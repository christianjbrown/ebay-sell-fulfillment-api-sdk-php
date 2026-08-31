<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToReleaseInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionsToReleaseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionsToReleaseTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionToReleaseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SellerActionsToReleaseTransformer::class)]
final class SellerActionsToReleaseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(SellerActionToReleaseInterface::class);
        $second = self::createStub(SellerActionToReleaseInterface::class);

        $sellerActionToReleaseTransformer = self::createStub(SellerActionToReleaseTransformerInterface::class);
        $sellerActionToReleaseTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new SellerActionsToReleaseTransformer($sellerActionToReleaseTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new SellerActionsToReleaseTransformer(self::createStub(SellerActionToReleaseTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new SellerActionsToReleaseTransformer(self::createStub(SellerActionToReleaseTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SellerActionsToReleaseTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SellerActionsToReleaseTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
