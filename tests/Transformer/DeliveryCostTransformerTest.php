<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\DeliveryCost;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DeliveryCostTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DeliveryCostTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeliveryCost::class)]
#[CoversClass(DeliveryCostTransformer::class)]
final class DeliveryCostTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $discountAmountData = ['__discountAmount__'];
        $handlingCostData = ['__handlingCost__'];
        $importChargesData = ['__importCharges__'];
        $shippingCostData = ['__shippingCost__'];
        $shippingIntermediationFeeData = ['__shippingIntermediationFee__'];

        $discountAmount = self::createStub(AmountInterface::class);
        $handlingCost = self::createStub(AmountInterface::class);
        $importCharges = self::createStub(AmountInterface::class);
        $shippingCost = self::createStub(AmountInterface::class);
        $shippingIntermediationFee = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$discountAmountData, $discountAmount],
                    [$handlingCostData, $handlingCost],
                    [$importChargesData, $importCharges],
                    [$shippingCostData, $shippingCost],
                    [$shippingIntermediationFeeData, $shippingIntermediationFee],
                ]
            );

        $data = [
            DeliveryCostTransformerInterface::KEY_DISCOUNT_AMOUNT => $discountAmountData,
            DeliveryCostTransformerInterface::KEY_HANDLING_COST => $handlingCostData,
            DeliveryCostTransformerInterface::KEY_IMPORT_CHARGES => $importChargesData,
            DeliveryCostTransformerInterface::KEY_SHIPPING_COST => $shippingCostData,
            DeliveryCostTransformerInterface::KEY_SHIPPING_INTERMEDIATION_FEE => $shippingIntermediationFeeData,
        ];

        $transformer = new DeliveryCostTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($discountAmount, $actual->getDiscountAmount());
        self::assertSame($handlingCost, $actual->getHandlingCost());
        self::assertSame($importCharges, $actual->getImportCharges());
        self::assertSame($shippingCost, $actual->getShippingCost());
        self::assertSame($shippingIntermediationFee, $actual->getShippingIntermediationFee());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformDiscountAmountNotSetCases')]
    public function testTransformDiscountAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getDiscountAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformDiscountAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DeliveryCostTransformerInterface::KEY_DISCOUNT_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformHandlingCostNotSetCases')]
    public function testTransformHandlingCostNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getHandlingCost());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformHandlingCostNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DeliveryCostTransformerInterface::KEY_HANDLING_COST => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformImportChargesNotSetCases')]
    public function testTransformImportChargesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getImportCharges());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformImportChargesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DeliveryCostTransformerInterface::KEY_IMPORT_CHARGES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformShippingCostNotSetCases')]
    public function testTransformShippingCostNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getShippingCost());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformShippingCostNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DeliveryCostTransformerInterface::KEY_SHIPPING_COST => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformShippingIntermediationFeeNotSetCases')]
    public function testTransformShippingIntermediationFeeNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getShippingIntermediationFee());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformShippingIntermediationFeeNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DeliveryCostTransformerInterface::KEY_SHIPPING_INTERMEDIATION_FEE => 'not-an-array']];
    }

    private function buildTransformer(): DeliveryCostTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new DeliveryCostTransformer($amountTransformer);
    }
}
