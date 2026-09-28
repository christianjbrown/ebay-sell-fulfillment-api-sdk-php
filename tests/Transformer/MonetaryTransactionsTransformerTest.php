<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransactionInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(MonetaryTransactionsTransformer::class)]
final class MonetaryTransactionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(MonetaryTransactionInterface::class);
        $second = self::createStub(MonetaryTransactionInterface::class);

        $monetaryTransactionTransformer = self::createStub(MonetaryTransactionTransformerInterface::class);
        $monetaryTransactionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new MonetaryTransactionsTransformer($monetaryTransactionTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new MonetaryTransactionsTransformer(self::createStub(MonetaryTransactionTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(MonetaryTransactionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, MonetaryTransactionsTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', MonetaryTransactionsTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new MonetaryTransactionsTransformer(self::createStub(MonetaryTransactionTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
