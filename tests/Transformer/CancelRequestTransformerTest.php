<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelRequest;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CancelRequest::class)]
#[CoversClass(CancelRequestTransformer::class)]
final class CancelRequestTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CancelRequestTransformerInterface::KEY_CANCEL_COMPLETED_DATE => 'test-cancelCompletedDate',
            CancelRequestTransformerInterface::KEY_CANCEL_INITIATOR => 'test-cancelInitiator',
            CancelRequestTransformerInterface::KEY_CANCEL_REASON => 'test-cancelReason',
            CancelRequestTransformerInterface::KEY_CANCEL_REQUESTED_DATE => 'test-cancelRequestedDate',
            CancelRequestTransformerInterface::KEY_CANCEL_REQUEST_ID => 'test-cancelRequestId',
            CancelRequestTransformerInterface::KEY_CANCEL_REQUEST_STATE => 'test-cancelRequestState',
        ];

        $transformer = new CancelRequestTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-cancelCompletedDate', $actual->getCancelCompletedDate());
        self::assertSame('test-cancelInitiator', $actual->getCancelInitiator());
        self::assertSame('test-cancelReason', $actual->getCancelReason());
        self::assertSame('test-cancelRequestedDate', $actual->getCancelRequestedDate());
        self::assertSame('test-cancelRequestId', $actual->getCancelRequestId());
        self::assertSame('test-cancelRequestState', $actual->getCancelRequestState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCancelCompletedDate, ?string $expectedCancelInitiator, ?string $expectedCancelReason, ?string $expectedCancelRequestedDate, ?string $expectedCancelRequestId, ?string $expectedCancelRequestState): void
    {
        $transformer = new CancelRequestTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCancelCompletedDate, $actual->getCancelCompletedDate());
        self::assertSame($expectedCancelInitiator, $actual->getCancelInitiator());
        self::assertSame($expectedCancelReason, $actual->getCancelReason());
        self::assertSame($expectedCancelRequestedDate, $actual->getCancelRequestedDate());
        self::assertSame($expectedCancelRequestId, $actual->getCancelRequestId());
        self::assertSame($expectedCancelRequestState, $actual->getCancelRequestState());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null];

        yield 'cancelCompletedDateWrongType' => [[CancelRequestTransformerInterface::KEY_CANCEL_COMPLETED_DATE => 42], null, null, null, null, null, null];

        yield 'cancelInitiatorWrongType' => [[CancelRequestTransformerInterface::KEY_CANCEL_INITIATOR => 42], null, null, null, null, null, null];

        yield 'cancelReasonWrongType' => [[CancelRequestTransformerInterface::KEY_CANCEL_REASON => 42], null, null, null, null, null, null];

        yield 'cancelRequestedDateWrongType' => [[CancelRequestTransformerInterface::KEY_CANCEL_REQUESTED_DATE => 42], null, null, null, null, null, null];

        yield 'cancelRequestIdWrongType' => [[CancelRequestTransformerInterface::KEY_CANCEL_REQUEST_ID => 42], null, null, null, null, null, null];

        yield 'cancelRequestStateWrongType' => [[CancelRequestTransformerInterface::KEY_CANCEL_REQUEST_STATE => 42], null, null, null, null, null, null];
    }
}
