<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentHoldInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentHoldsTransformer::class)]
final class PaymentHoldsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(PaymentHoldInterface::class);
        $second = self::createStub(PaymentHoldInterface::class);

        $paymentHoldTransformer = self::createStub(PaymentHoldTransformerInterface::class);
        $paymentHoldTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new PaymentHoldsTransformer($paymentHoldTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new PaymentHoldsTransformer(self::createStub(PaymentHoldTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new PaymentHoldsTransformer(self::createStub(PaymentHoldTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(PaymentHoldsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PaymentHoldsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
