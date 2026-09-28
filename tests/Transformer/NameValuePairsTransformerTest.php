<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\NameValuePairInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NameValuePairsTransformer::class)]
final class NameValuePairsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(NameValuePairInterface::class);
        $second = self::createStub(NameValuePairInterface::class);

        $nameValuePairTransformer = self::createStub(NameValuePairTransformerInterface::class);
        $nameValuePairTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new NameValuePairsTransformer($nameValuePairTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new NameValuePairsTransformer(self::createStub(NameValuePairTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(NameValuePairsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, NameValuePairsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', NameValuePairsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new NameValuePairsTransformer(self::createStub(NameValuePairTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
