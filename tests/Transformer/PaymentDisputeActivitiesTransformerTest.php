<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivitiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivitiesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentDisputeActivitiesTransformer::class)]
final class PaymentDisputeActivitiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(PaymentDisputeActivityInterface::class);
        $second = self::createStub(PaymentDisputeActivityInterface::class);

        $paymentDisputeActivityTransformer = self::createStub(PaymentDisputeActivityTransformerInterface::class);
        $paymentDisputeActivityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new PaymentDisputeActivitiesTransformer($paymentDisputeActivityTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new PaymentDisputeActivitiesTransformer(self::createStub(PaymentDisputeActivityTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(PaymentDisputeActivitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PaymentDisputeActivitiesTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', PaymentDisputeActivitiesTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new PaymentDisputeActivitiesTransformer(self::createStub(PaymentDisputeActivityTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
