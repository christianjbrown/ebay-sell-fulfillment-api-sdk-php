<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PaymentsTransformer::class)]
final class PaymentsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(PaymentInterface::class);
        $second = self::createStub(PaymentInterface::class);

        $paymentTransformer = self::createStub(PaymentTransformerInterface::class);
        $paymentTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new PaymentsTransformer($paymentTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new PaymentsTransformer(self::createStub(PaymentTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new PaymentsTransformer(self::createStub(PaymentTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(PaymentsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PaymentsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
