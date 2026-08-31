<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTax;
use ChristianBrown\EBay\SellFulfillment\Model\EbayTaxReferenceInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayTaxReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EbayCollectAndRemitTax::class)]
#[CoversClass(EbayCollectAndRemitTaxTransformer::class)]
final class EbayCollectAndRemitTaxTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $amountData = ['__amount__'];
        $ebayReferenceData = ['__ebayReference__'];

        $amount = self::createStub(AmountInterface::class);
        $ebayReference = self::createStub(EbayTaxReferenceInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$amountData, $amount],
                ]
            );
        $ebayTaxReferenceTransformer = self::createStub(EbayTaxReferenceTransformerInterface::class);
        $ebayTaxReferenceTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayReferenceData, $ebayReference],
                ]
            );

        $data = [
            EbayCollectAndRemitTaxTransformerInterface::KEY_AMOUNT => $amountData,
            EbayCollectAndRemitTaxTransformerInterface::KEY_COLLECTION_METHOD => 'test-collectionMethod',
            EbayCollectAndRemitTaxTransformerInterface::KEY_EBAY_REFERENCE => $ebayReferenceData,
            EbayCollectAndRemitTaxTransformerInterface::KEY_TAX_TYPE => 'test-taxType',
        ];

        $transformer = new EbayCollectAndRemitTaxTransformer($amountTransformer, $ebayTaxReferenceTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-collectionMethod', $actual->getCollectionMethod());
        self::assertSame($ebayReference, $actual->getEbayReference());
        self::assertSame('test-taxType', $actual->getTaxType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformAmountNotSetCases')]
    public function testTransformAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[EbayCollectAndRemitTaxTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEbayReferenceNotSetCases')]
    public function testTransformEbayReferenceNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getEbayReference());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEbayReferenceNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[EbayCollectAndRemitTaxTransformerInterface::KEY_EBAY_REFERENCE => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCollectionMethod, ?string $expectedTaxType): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCollectionMethod, $actual->getCollectionMethod());
        self::assertSame($expectedTaxType, $actual->getTaxType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'collectionMethodWrongType' => [[EbayCollectAndRemitTaxTransformerInterface::KEY_COLLECTION_METHOD => 42], null, null];

        yield 'taxTypeWrongType' => [[EbayCollectAndRemitTaxTransformerInterface::KEY_TAX_TYPE => 42], null, null];
    }

    private function buildTransformer(): EbayCollectAndRemitTaxTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $ebayTaxReferenceTransformer = self::createStub(EbayTaxReferenceTransformerInterface::class);

        return new EbayCollectAndRemitTaxTransformer($amountTransformer, $ebayTaxReferenceTransformer);
    }
}
