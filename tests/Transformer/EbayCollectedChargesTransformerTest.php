<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ChargeInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedCharges;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectedChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectedChargesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EbayCollectedCharges::class)]
#[CoversClass(EbayCollectedChargesTransformer::class)]
final class EbayCollectedChargesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $ebayShippingData = ['__ebayShipping__'];
        $chargesData = [['__charge__']];

        $ebayShipping = self::createStub(AmountInterface::class);
        $charges = [self::createStub(ChargeInterface::class)];

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayShippingData, $ebayShipping],
                ]
            );

        $chargesTransformer = self::createStub(ChargesTransformerInterface::class);
        $chargesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$chargesData, $charges],
                ]
            );

        $data = [
            EbayCollectedChargesTransformerInterface::KEY_CHARGES => $chargesData,
            EbayCollectedChargesTransformerInterface::KEY_EBAY_SHIPPING => $ebayShippingData,
        ];

        $transformer = new EbayCollectedChargesTransformer($amountTransformer, $chargesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($charges, $actual->getCharges());
        self::assertSame($ebayShipping, $actual->getEbayShipping());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformChargesNotSetCases')]
    public function testTransformChargesNotSet(array $data): void
    {
        $chargesTransformer = self::createStub(ChargesTransformerInterface::class);
        $transformer = new EbayCollectedChargesTransformer(self::createStub(AmountTransformerInterface::class), $chargesTransformer);

        self::assertSame([], $transformer->transform($data)->getCharges());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformChargesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[EbayCollectedChargesTransformerInterface::KEY_CHARGES => 'not-an-array']];
    }

    public function testTransformChargesTransformerNotInjected(): void
    {
        $data = [
            EbayCollectedChargesTransformerInterface::KEY_CHARGES => [['__charge__']],
        ];

        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getCharges());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEbayShippingNotSetCases')]
    public function testTransformEbayShippingNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getEbayShipping());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEbayShippingNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[EbayCollectedChargesTransformerInterface::KEY_EBAY_SHIPPING => 'not-an-array']];
    }

    private function buildTransformer(): EbayCollectedChargesTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new EbayCollectedChargesTransformer($amountTransformer);
    }
}
