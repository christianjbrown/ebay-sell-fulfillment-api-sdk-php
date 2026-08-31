<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeEvidence;
use ChristianBrown\EBay\SellFulfillment\Model\FileInfoInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidenceTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfosTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfosTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DisputeEvidence::class)]
#[CoversClass(DisputeEvidenceTransformer::class)]
final class DisputeEvidenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $filesData = ['__files__'];
        $lineItemsData = ['__lineItems__'];
        $shipmentTrackingData = ['__shipmentTracking__'];

        $files = [self::createStub(FileInfoInterface::class)];
        $lineItems = [self::createStub(OrderLineItemInterface::class)];
        $shipmentTracking = [self::createStub(TrackingInfoInterface::class)];

        $fileInfosTransformer = self::createStub(FileInfosTransformerInterface::class);
        $fileInfosTransformer->method('transform')
            ->willReturnMap(
                [
                    [$filesData, $files],
                ]
            );
        $orderLineItemsTransformer = self::createStub(OrderLineItemsTransformerInterface::class);
        $orderLineItemsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$lineItemsData, $lineItems],
                ]
            );
        $trackingInfosTransformer = self::createStub(TrackingInfosTransformerInterface::class);
        $trackingInfosTransformer->method('transform')
            ->willReturnMap(
                [
                    [$shipmentTrackingData, $shipmentTracking],
                ]
            );

        $data = [
            DisputeEvidenceTransformerInterface::KEY_EVIDENCE_ID => 'test-evidenceId',
            DisputeEvidenceTransformerInterface::KEY_EVIDENCE_TYPE => 'test-evidenceType',
            DisputeEvidenceTransformerInterface::KEY_FILES => $filesData,
            DisputeEvidenceTransformerInterface::KEY_LINE_ITEMS => $lineItemsData,
            DisputeEvidenceTransformerInterface::KEY_PROVIDED_DATE => 'test-providedDate',
            DisputeEvidenceTransformerInterface::KEY_REQUEST_DATE => 'test-requestDate',
            DisputeEvidenceTransformerInterface::KEY_RESPOND_BY_DATE => 'test-respondByDate',
            DisputeEvidenceTransformerInterface::KEY_SHIPMENT_TRACKING => $shipmentTrackingData,
        ];

        $transformer = new DisputeEvidenceTransformer($fileInfosTransformer, $orderLineItemsTransformer, $trackingInfosTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-evidenceId', $actual->getEvidenceId());
        self::assertSame('test-evidenceType', $actual->getEvidenceType());
        self::assertSame($files, $actual->getFiles());
        self::assertSame($lineItems, $actual->getLineItems());
        self::assertSame('test-providedDate', $actual->getProvidedDate());
        self::assertSame('test-requestDate', $actual->getRequestDate());
        self::assertSame('test-respondByDate', $actual->getRespondByDate());
        self::assertSame($shipmentTracking, $actual->getShipmentTracking());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFilesNotSetCases')]
    public function testTransformFilesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getFiles());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFilesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DisputeEvidenceTransformerInterface::KEY_FILES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLineItemsNotSetCases')]
    public function testTransformLineItemsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getLineItems());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLineItemsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DisputeEvidenceTransformerInterface::KEY_LINE_ITEMS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedEvidenceId, ?string $expectedEvidenceType, ?string $expectedProvidedDate, ?string $expectedRequestDate, ?string $expectedRespondByDate): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedEvidenceId, $actual->getEvidenceId());
        self::assertSame($expectedEvidenceType, $actual->getEvidenceType());
        self::assertSame($expectedProvidedDate, $actual->getProvidedDate());
        self::assertSame($expectedRequestDate, $actual->getRequestDate());
        self::assertSame($expectedRespondByDate, $actual->getRespondByDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null];

        yield 'evidenceIdWrongType' => [[DisputeEvidenceTransformerInterface::KEY_EVIDENCE_ID => 42], null, null, null, null, null];

        yield 'evidenceTypeWrongType' => [[DisputeEvidenceTransformerInterface::KEY_EVIDENCE_TYPE => 42], null, null, null, null, null];

        yield 'providedDateWrongType' => [[DisputeEvidenceTransformerInterface::KEY_PROVIDED_DATE => 42], null, null, null, null, null];

        yield 'requestDateWrongType' => [[DisputeEvidenceTransformerInterface::KEY_REQUEST_DATE => 42], null, null, null, null, null];

        yield 'respondByDateWrongType' => [[DisputeEvidenceTransformerInterface::KEY_RESPOND_BY_DATE => 42], null, null, null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformShipmentTrackingNotSetCases')]
    public function testTransformShipmentTrackingNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getShipmentTracking());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformShipmentTrackingNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DisputeEvidenceTransformerInterface::KEY_SHIPMENT_TRACKING => 'not-an-array']];
    }

    private function buildTransformer(): DisputeEvidenceTransformer
    {
        $fileInfosTransformer = self::createStub(FileInfosTransformerInterface::class);
        $orderLineItemsTransformer = self::createStub(OrderLineItemsTransformerInterface::class);
        $trackingInfosTransformer = self::createStub(TrackingInfosTransformerInterface::class);

        return new DisputeEvidenceTransformer($fileInfosTransformer, $orderLineItemsTransformer, $trackingInfosTransformer);
    }
}
