<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Model\CancelStatus;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelStatusTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelStatusTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CancelStatus::class)]
#[CoversClass(CancelStatusTransformer::class)]
final class CancelStatusTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $cancelRequestsData = ['__cancelRequests__'];

        $cancelRequests = [self::createStub(CancelRequestInterface::class)];

        $cancelRequestsTransformer = self::createStub(CancelRequestsTransformerInterface::class);
        $cancelRequestsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$cancelRequestsData, $cancelRequests],
                ]
            );

        $data = [
            CancelStatusTransformerInterface::KEY_CANCELLED_DATE => 'test-cancelledDate',
            CancelStatusTransformerInterface::KEY_CANCEL_REQUESTS => $cancelRequestsData,
            CancelStatusTransformerInterface::KEY_CANCEL_STATE => 'test-cancelState',
        ];

        $transformer = new CancelStatusTransformer($cancelRequestsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-cancelledDate', $actual->getCancelledDate());
        self::assertSame($cancelRequests, $actual->getCancelRequests());
        self::assertSame('test-cancelState', $actual->getCancelState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformCancelRequestsNotSetCases')]
    public function testTransformCancelRequestsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getCancelRequests());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformCancelRequestsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[CancelStatusTransformerInterface::KEY_CANCEL_REQUESTS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCancelledDate, ?string $expectedCancelState): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCancelledDate, $actual->getCancelledDate());
        self::assertSame($expectedCancelState, $actual->getCancelState());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'cancelledDateWrongType' => [[CancelStatusTransformerInterface::KEY_CANCELLED_DATE => 42], null, null];

        yield 'cancelStateWrongType' => [[CancelStatusTransformerInterface::KEY_CANCEL_STATE => 42], null, null];
    }

    private function buildTransformer(): CancelStatusTransformer
    {
        $cancelRequestsTransformer = self::createStub(CancelRequestsTransformerInterface::class);

        return new CancelStatusTransformer($cancelRequestsTransformer);
    }
}
