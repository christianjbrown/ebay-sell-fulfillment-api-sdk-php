<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ExtendedContactInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingStep;
use ChristianBrown\EBay\SellFulfillment\Transformer\ExtendedContactTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingStepTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingStepTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShippingStep::class)]
#[CoversClass(ShippingStepTransformer::class)]
final class ShippingStepTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $shipToData = ['__shipTo__'];

        $shipTo = self::createStub(ExtendedContactInterface::class);

        $extendedContactTransformer = self::createStub(ExtendedContactTransformerInterface::class);
        $extendedContactTransformer->method('transform')
            ->willReturnMap(
                [
                    [$shipToData, $shipTo],
                ]
            );

        $data = [
            ShippingStepTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 'test-shippingCarrierCode',
            ShippingStepTransformerInterface::KEY_SHIPPING_SERVICE_CODE => 'test-shippingServiceCode',
            ShippingStepTransformerInterface::KEY_SHIP_TO => $shipToData,
            ShippingStepTransformerInterface::KEY_SHIP_TO_REFERENCE_ID => 'test-shipToReferenceId',
        ];

        $transformer = new ShippingStepTransformer($extendedContactTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-shippingCarrierCode', $actual->getShippingCarrierCode());
        self::assertSame('test-shippingServiceCode', $actual->getShippingServiceCode());
        self::assertSame($shipTo, $actual->getShipTo());
        self::assertSame('test-shipToReferenceId', $actual->getShipToReferenceId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedShippingCarrierCode, ?string $expectedShippingServiceCode, ?string $expectedShipToReferenceId): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedShippingCarrierCode, $actual->getShippingCarrierCode());
        self::assertSame($expectedShippingServiceCode, $actual->getShippingServiceCode());
        self::assertSame($expectedShipToReferenceId, $actual->getShipToReferenceId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'shippingCarrierCodeWrongType' => [[ShippingStepTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 42], null, null, null];

        yield 'shippingServiceCodeWrongType' => [[ShippingStepTransformerInterface::KEY_SHIPPING_SERVICE_CODE => 42], null, null, null];

        yield 'shipToReferenceIdWrongType' => [[ShippingStepTransformerInterface::KEY_SHIP_TO_REFERENCE_ID => 42], null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformShipToNotSetCases')]
    public function testTransformShipToNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getShipTo());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformShipToNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ShippingStepTransformerInterface::KEY_SHIP_TO => 'not-an-array']];
    }

    private function buildTransformer(): ShippingStepTransformer
    {
        $extendedContactTransformer = self::createStub(ExtendedContactTransformerInterface::class);

        return new ShippingStepTransformer($extendedContactTransformer);
    }
}
