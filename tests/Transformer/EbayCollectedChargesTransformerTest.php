<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedCharges;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
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

        $ebayShipping = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayShippingData, $ebayShipping],
                ]
            );

        $data = [
            EbayCollectedChargesTransformerInterface::KEY_EBAY_SHIPPING => $ebayShippingData,
        ];

        $transformer = new EbayCollectedChargesTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($ebayShipping, $actual->getEbayShipping());
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
