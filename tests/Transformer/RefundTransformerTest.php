<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Refund;
use ChristianBrown\EBay\SellFulfillment\Transformer\RefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\RefundTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Refund::class)]
#[CoversClass(RefundTransformer::class)]
final class RefundTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RefundTransformerInterface::KEY_REFUND_ID => 'test-refundId',
            RefundTransformerInterface::KEY_REFUND_STATUS => 'test-refundStatus',
        ];

        $transformer = new RefundTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-refundId', $actual->getRefundId());
        self::assertSame('test-refundStatus', $actual->getRefundStatus());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedRefundId, ?string $expectedRefundStatus): void
    {
        $transformer = new RefundTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedRefundId, $actual->getRefundId());
        self::assertSame($expectedRefundStatus, $actual->getRefundStatus());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'refundIdWrongType' => [[RefundTransformerInterface::KEY_REFUND_ID => 42], null, null];

        yield 'refundStatusWrongType' => [[RefundTransformerInterface::KEY_REFUND_STATUS => 42], null, null];
    }
}
