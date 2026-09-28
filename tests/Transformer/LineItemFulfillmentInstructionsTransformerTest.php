<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemFulfillmentInstructions;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemFulfillmentInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemFulfillmentInstructionsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineItemFulfillmentInstructions::class)]
#[CoversClass(LineItemFulfillmentInstructionsTransformer::class)]
final class LineItemFulfillmentInstructionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LineItemFulfillmentInstructionsTransformerInterface::KEY_DESTINATION_TIME_ZONE => 'test-destinationTimeZone',
            LineItemFulfillmentInstructionsTransformerInterface::KEY_GUARANTEED_DELIVERY => true,
            LineItemFulfillmentInstructionsTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 'test-maxEstimatedDeliveryDate',
            LineItemFulfillmentInstructionsTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 'test-minEstimatedDeliveryDate',
            LineItemFulfillmentInstructionsTransformerInterface::KEY_SHIP_BY_DATE => 'test-shipByDate',
            LineItemFulfillmentInstructionsTransformerInterface::KEY_SOURCE_TIME_ZONE => 'test-sourceTimeZone',
        ];

        $transformer = new LineItemFulfillmentInstructionsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-destinationTimeZone', $actual->getDestinationTimeZone());
        self::assertTrue($actual->getGuaranteedDelivery());
        self::assertSame('test-maxEstimatedDeliveryDate', $actual->getMaxEstimatedDeliveryDate());
        self::assertSame('test-minEstimatedDeliveryDate', $actual->getMinEstimatedDeliveryDate());
        self::assertSame('test-shipByDate', $actual->getShipByDate());
        self::assertSame('test-sourceTimeZone', $actual->getSourceTimeZone());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedDestinationTimeZone, ?bool $expectedGuaranteedDelivery, ?string $expectedMaxEstimatedDeliveryDate, ?string $expectedMinEstimatedDeliveryDate, ?string $expectedShipByDate, ?string $expectedSourceTimeZone): void
    {
        $transformer = new LineItemFulfillmentInstructionsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedDestinationTimeZone, $actual->getDestinationTimeZone());
        self::assertSame($expectedGuaranteedDelivery, $actual->getGuaranteedDelivery());
        self::assertSame($expectedMaxEstimatedDeliveryDate, $actual->getMaxEstimatedDeliveryDate());
        self::assertSame($expectedMinEstimatedDeliveryDate, $actual->getMinEstimatedDeliveryDate());
        self::assertSame($expectedShipByDate, $actual->getShipByDate());
        self::assertSame($expectedSourceTimeZone, $actual->getSourceTimeZone());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?bool, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null];

        yield 'destinationTimeZoneWrongType' => [[LineItemFulfillmentInstructionsTransformerInterface::KEY_DESTINATION_TIME_ZONE => 42], null, null, null, null, null, null];

        yield 'guaranteedDeliveryFalse' => [[LineItemFulfillmentInstructionsTransformerInterface::KEY_GUARANTEED_DELIVERY => false], null, false, null, null, null, null];

        yield 'guaranteedDeliveryWrongType' => [[LineItemFulfillmentInstructionsTransformerInterface::KEY_GUARANTEED_DELIVERY => 'not-bool'], null, null, null, null, null, null];

        yield 'maxEstimatedDeliveryDateWrongType' => [[LineItemFulfillmentInstructionsTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 42], null, null, null, null, null, null];

        yield 'minEstimatedDeliveryDateWrongType' => [[LineItemFulfillmentInstructionsTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 42], null, null, null, null, null, null];

        yield 'shipByDateWrongType' => [[LineItemFulfillmentInstructionsTransformerInterface::KEY_SHIP_BY_DATE => 42], null, null, null, null, null, null];

        yield 'sourceTimeZoneWrongType' => [[LineItemFulfillmentInstructionsTransformerInterface::KEY_SOURCE_TIME_ZONE => 42], null, null, null, null, null, null];
    }
}
