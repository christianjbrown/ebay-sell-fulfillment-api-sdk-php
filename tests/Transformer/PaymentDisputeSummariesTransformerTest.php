<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummaryInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummariesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummariesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummaryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentDisputeSummariesTransformer::class)]
final class PaymentDisputeSummariesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(PaymentDisputeSummaryInterface::class);
        $second = self::createStub(PaymentDisputeSummaryInterface::class);

        $paymentDisputeSummaryTransformer = self::createStub(PaymentDisputeSummaryTransformerInterface::class);
        $paymentDisputeSummaryTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new PaymentDisputeSummariesTransformer($paymentDisputeSummaryTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new PaymentDisputeSummariesTransformer(self::createStub(PaymentDisputeSummaryTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(PaymentDisputeSummariesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PaymentDisputeSummariesTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', PaymentDisputeSummariesTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new PaymentDisputeSummariesTransformer(self::createStub(PaymentDisputeSummaryTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
