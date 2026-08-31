<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PricingSummary;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PricingSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PricingSummaryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PricingSummary::class)]
#[CoversClass(PricingSummaryTransformer::class)]
final class PricingSummaryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $adjustmentData = ['__adjustment__'];
        $deliveryCostData = ['__deliveryCost__'];
        $deliveryDiscountData = ['__deliveryDiscount__'];
        $feeData = ['__fee__'];
        $priceDiscountData = ['__priceDiscount__'];
        $priceSubtotalData = ['__priceSubtotal__'];
        $taxData = ['__tax__'];
        $totalData = ['__total__'];

        $adjustment = self::createStub(AmountInterface::class);
        $deliveryCost = self::createStub(AmountInterface::class);
        $deliveryDiscount = self::createStub(AmountInterface::class);
        $fee = self::createStub(AmountInterface::class);
        $priceDiscount = self::createStub(AmountInterface::class);
        $priceSubtotal = self::createStub(AmountInterface::class);
        $tax = self::createStub(AmountInterface::class);
        $total = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$adjustmentData, $adjustment],
                    [$deliveryCostData, $deliveryCost],
                    [$deliveryDiscountData, $deliveryDiscount],
                    [$feeData, $fee],
                    [$priceDiscountData, $priceDiscount],
                    [$priceSubtotalData, $priceSubtotal],
                    [$taxData, $tax],
                    [$totalData, $total],
                ]
            );

        $data = [
            PricingSummaryTransformerInterface::KEY_ADJUSTMENT => $adjustmentData,
            PricingSummaryTransformerInterface::KEY_DELIVERY_COST => $deliveryCostData,
            PricingSummaryTransformerInterface::KEY_DELIVERY_DISCOUNT => $deliveryDiscountData,
            PricingSummaryTransformerInterface::KEY_FEE => $feeData,
            PricingSummaryTransformerInterface::KEY_PRICE_DISCOUNT => $priceDiscountData,
            PricingSummaryTransformerInterface::KEY_PRICE_SUBTOTAL => $priceSubtotalData,
            PricingSummaryTransformerInterface::KEY_TAX => $taxData,
            PricingSummaryTransformerInterface::KEY_TOTAL => $totalData,
        ];

        $transformer = new PricingSummaryTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($adjustment, $actual->getAdjustment());
        self::assertSame($deliveryCost, $actual->getDeliveryCost());
        self::assertSame($deliveryDiscount, $actual->getDeliveryDiscount());
        self::assertSame($fee, $actual->getFee());
        self::assertSame($priceDiscount, $actual->getPriceDiscount());
        self::assertSame($priceSubtotal, $actual->getPriceSubtotal());
        self::assertSame($tax, $actual->getTax());
        self::assertSame($total, $actual->getTotal());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformAdjustmentNotSetCases')]
    public function testTransformAdjustmentNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getAdjustment());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformAdjustmentNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_ADJUSTMENT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformDeliveryCostNotSetCases')]
    public function testTransformDeliveryCostNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getDeliveryCost());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformDeliveryCostNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_DELIVERY_COST => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformDeliveryDiscountNotSetCases')]
    public function testTransformDeliveryDiscountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getDeliveryDiscount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformDeliveryDiscountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_DELIVERY_DISCOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFeeNotSetCases')]
    public function testTransformFeeNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getFee());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFeeNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_FEE => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPriceDiscountNotSetCases')]
    public function testTransformPriceDiscountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getPriceDiscount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPriceDiscountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_PRICE_DISCOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPriceSubtotalNotSetCases')]
    public function testTransformPriceSubtotalNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getPriceSubtotal());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPriceSubtotalNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_PRICE_SUBTOTAL => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTaxNotSetCases')]
    public function testTransformTaxNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTax());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTaxNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_TAX => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTotalNotSetCases')]
    public function testTransformTotalNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTotal());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTotalNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PricingSummaryTransformerInterface::KEY_TOTAL => 'not-an-array']];
    }

    private function buildTransformer(): PricingSummaryTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new PricingSummaryTransformer($amountTransformer);
    }
}
