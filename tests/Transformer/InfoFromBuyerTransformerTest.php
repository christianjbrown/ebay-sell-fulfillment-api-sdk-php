<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\InfoFromBuyer;
use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\InfoFromBuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\InfoFromBuyerTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfosTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(InfoFromBuyer::class)]
#[CoversClass(InfoFromBuyerTransformer::class)]
final class InfoFromBuyerTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $returnShipmentTrackingData = ['__returnShipmentTracking__'];

        $returnShipmentTracking = [self::createStub(TrackingInfoInterface::class)];

        $trackingInfosTransformer = self::createStub(TrackingInfosTransformerInterface::class);
        $trackingInfosTransformer->method('transform')
            ->willReturnMap(
                [
                    [$returnShipmentTrackingData, $returnShipmentTracking],
                ]
            );

        $data = [
            InfoFromBuyerTransformerInterface::KEY_NOTE => 'test-note',
            InfoFromBuyerTransformerInterface::KEY_RETURN_SHIPMENT_TRACKING => $returnShipmentTrackingData,
        ];

        $transformer = new InfoFromBuyerTransformer($trackingInfosTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-note', $actual->getNote());
        self::assertSame($returnShipmentTracking, $actual->getReturnShipmentTracking());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformReturnShipmentTrackingNotSetCases')]
    public function testTransformReturnShipmentTrackingNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getReturnShipmentTracking());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformReturnShipmentTrackingNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[InfoFromBuyerTransformerInterface::KEY_RETURN_SHIPMENT_TRACKING => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedNote): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedNote, $actual->getNote());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'noteWrongType' => [[InfoFromBuyerTransformerInterface::KEY_NOTE => 42], null];
    }

    private function buildTransformer(): InfoFromBuyerTransformer
    {
        $trackingInfosTransformer = self::createStub(TrackingInfosTransformerInterface::class);

        return new InfoFromBuyerTransformer($trackingInfosTransformer);
    }
}
