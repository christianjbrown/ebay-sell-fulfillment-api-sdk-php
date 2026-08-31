<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AddressInterface;
use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstruction;
use ChristianBrown\EBay\SellFulfillment\Model\PickupStepInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingStepInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddressTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PickupStepTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingStepTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(FulfillmentStartInstruction::class)]
#[CoversClass(FulfillmentStartInstructionTransformer::class)]
final class FulfillmentStartInstructionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $finalDestinationAddressData = ['__finalDestinationAddress__'];
        $pickupStepData = ['__pickupStep__'];
        $shippingStepData = ['__shippingStep__'];

        $finalDestinationAddress = self::createStub(AddressInterface::class);
        $pickupStep = self::createStub(PickupStepInterface::class);
        $shippingStep = self::createStub(ShippingStepInterface::class);

        $addressTransformer = self::createStub(AddressTransformerInterface::class);
        $addressTransformer->method('transform')
            ->willReturnMap(
                [
                    [$finalDestinationAddressData, $finalDestinationAddress],
                ]
            );
        $pickupStepTransformer = self::createStub(PickupStepTransformerInterface::class);
        $pickupStepTransformer->method('transform')
            ->willReturnMap(
                [
                    [$pickupStepData, $pickupStep],
                ]
            );
        $shippingStepTransformer = self::createStub(ShippingStepTransformerInterface::class);
        $shippingStepTransformer->method('transform')
            ->willReturnMap(
                [
                    [$shippingStepData, $shippingStep],
                ]
            );

        $data = [
            FulfillmentStartInstructionTransformerInterface::KEY_EBAY_SUPPORTED_FULFILLMENT => true,
            FulfillmentStartInstructionTransformerInterface::KEY_FINAL_DESTINATION_ADDRESS => $finalDestinationAddressData,
            FulfillmentStartInstructionTransformerInterface::KEY_FULFILLMENT_INSTRUCTIONS_TYPE => 'test-fulfillmentInstructionsType',
            FulfillmentStartInstructionTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 'test-maxEstimatedDeliveryDate',
            FulfillmentStartInstructionTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 'test-minEstimatedDeliveryDate',
            FulfillmentStartInstructionTransformerInterface::KEY_PICKUP_STEP => $pickupStepData,
            FulfillmentStartInstructionTransformerInterface::KEY_SHIPPING_STEP => $shippingStepData,
        ];

        $transformer = new FulfillmentStartInstructionTransformer($addressTransformer, $pickupStepTransformer, $shippingStepTransformer);

        $actual = $transformer->transform($data);

        self::assertTrue($actual->getEbaySupportedFulfillment());
        self::assertSame($finalDestinationAddress, $actual->getFinalDestinationAddress());
        self::assertSame('test-fulfillmentInstructionsType', $actual->getFulfillmentInstructionsType());
        self::assertSame('test-maxEstimatedDeliveryDate', $actual->getMaxEstimatedDeliveryDate());
        self::assertSame('test-minEstimatedDeliveryDate', $actual->getMinEstimatedDeliveryDate());
        self::assertSame($pickupStep, $actual->getPickupStep());
        self::assertSame($shippingStep, $actual->getShippingStep());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFinalDestinationAddressNotSetCases')]
    public function testTransformFinalDestinationAddressNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getFinalDestinationAddress());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFinalDestinationAddressNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[FulfillmentStartInstructionTransformerInterface::KEY_FINAL_DESTINATION_ADDRESS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPickupStepNotSetCases')]
    public function testTransformPickupStepNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getPickupStep());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPickupStepNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[FulfillmentStartInstructionTransformerInterface::KEY_PICKUP_STEP => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?bool $expectedEbaySupportedFulfillment, ?string $expectedFulfillmentInstructionsType, ?string $expectedMaxEstimatedDeliveryDate, ?string $expectedMinEstimatedDeliveryDate): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedEbaySupportedFulfillment, $actual->getEbaySupportedFulfillment());
        self::assertSame($expectedFulfillmentInstructionsType, $actual->getFulfillmentInstructionsType());
        self::assertSame($expectedMaxEstimatedDeliveryDate, $actual->getMaxEstimatedDeliveryDate());
        self::assertSame($expectedMinEstimatedDeliveryDate, $actual->getMinEstimatedDeliveryDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?bool, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'ebaySupportedFulfillmentFalse' => [[FulfillmentStartInstructionTransformerInterface::KEY_EBAY_SUPPORTED_FULFILLMENT => false], false, null, null, null];

        yield 'ebaySupportedFulfillmentWrongType' => [[FulfillmentStartInstructionTransformerInterface::KEY_EBAY_SUPPORTED_FULFILLMENT => 'not-bool'], null, null, null, null];

        yield 'fulfillmentInstructionsTypeWrongType' => [[FulfillmentStartInstructionTransformerInterface::KEY_FULFILLMENT_INSTRUCTIONS_TYPE => 42], null, null, null, null];

        yield 'maxEstimatedDeliveryDateWrongType' => [[FulfillmentStartInstructionTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 42], null, null, null, null];

        yield 'minEstimatedDeliveryDateWrongType' => [[FulfillmentStartInstructionTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 42], null, null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformShippingStepNotSetCases')]
    public function testTransformShippingStepNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getShippingStep());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformShippingStepNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[FulfillmentStartInstructionTransformerInterface::KEY_SHIPPING_STEP => 'not-an-array']];
    }

    private function buildTransformer(): FulfillmentStartInstructionTransformer
    {
        $addressTransformer = self::createStub(AddressTransformerInterface::class);
        $pickupStepTransformer = self::createStub(PickupStepTransformerInterface::class);
        $shippingStepTransformer = self::createStub(ShippingStepTransformerInterface::class);

        return new FulfillmentStartInstructionTransformer($addressTransformer, $pickupStepTransformer, $shippingStepTransformer);
    }
}
