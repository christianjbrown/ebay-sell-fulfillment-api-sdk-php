<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfosTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfosTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfoTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TrackingInfosTransformer::class)]
final class TrackingInfosTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(TrackingInfoInterface::class);
        $second = self::createStub(TrackingInfoInterface::class);

        $trackingInfoTransformer = self::createStub(TrackingInfoTransformerInterface::class);
        $trackingInfoTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new TrackingInfosTransformer($trackingInfoTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new TrackingInfosTransformer(self::createStub(TrackingInfoTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new TrackingInfosTransformer(self::createStub(TrackingInfoTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TrackingInfosTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, TrackingInfosTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
