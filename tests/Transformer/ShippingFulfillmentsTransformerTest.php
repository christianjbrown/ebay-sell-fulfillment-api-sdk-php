<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ShippingFulfillmentsTransformer::class)]
final class ShippingFulfillmentsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(ShippingFulfillmentInterface::class);
        $second = self::createStub(ShippingFulfillmentInterface::class);

        $shippingFulfillmentTransformer = self::createStub(ShippingFulfillmentTransformerInterface::class);
        $shippingFulfillmentTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new ShippingFulfillmentsTransformer($shippingFulfillmentTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new ShippingFulfillmentsTransformer(self::createStub(ShippingFulfillmentTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(ShippingFulfillmentsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ShippingFulfillmentsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', ShippingFulfillmentsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new ShippingFulfillmentsTransformer(self::createStub(ShippingFulfillmentTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
