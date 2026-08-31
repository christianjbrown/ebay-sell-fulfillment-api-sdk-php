<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\CancelRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CancelRequestsTransformer::class)]
final class CancelRequestsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(CancelRequestInterface::class);
        $second = self::createStub(CancelRequestInterface::class);

        $cancelRequestTransformer = self::createStub(CancelRequestTransformerInterface::class);
        $cancelRequestTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new CancelRequestsTransformer($cancelRequestTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new CancelRequestsTransformer(self::createStub(CancelRequestTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new CancelRequestsTransformer(self::createStub(CancelRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CancelRequestsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CancelRequestsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
