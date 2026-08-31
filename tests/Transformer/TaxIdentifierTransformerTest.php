<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TaxIdentifier;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxIdentifierTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxIdentifierTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TaxIdentifier::class)]
#[CoversClass(TaxIdentifierTransformer::class)]
final class TaxIdentifierTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TaxIdentifierTransformerInterface::KEY_ISSUING_COUNTRY => 'test-issuingCountry',
            TaxIdentifierTransformerInterface::KEY_TAX_IDENTIFIER_TYPE => 'test-taxIdentifierType',
            TaxIdentifierTransformerInterface::KEY_TAXPAYER_ID => 'test-taxpayerId',
        ];

        $transformer = new TaxIdentifierTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-issuingCountry', $actual->getIssuingCountry());
        self::assertSame('test-taxIdentifierType', $actual->getTaxIdentifierType());
        self::assertSame('test-taxpayerId', $actual->getTaxpayerId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedIssuingCountry, ?string $expectedTaxIdentifierType, ?string $expectedTaxpayerId): void
    {
        $transformer = new TaxIdentifierTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedIssuingCountry, $actual->getIssuingCountry());
        self::assertSame($expectedTaxIdentifierType, $actual->getTaxIdentifierType());
        self::assertSame($expectedTaxpayerId, $actual->getTaxpayerId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'issuingCountryWrongType' => [[TaxIdentifierTransformerInterface::KEY_ISSUING_COUNTRY => 42], null, null, null];

        yield 'taxIdentifierTypeWrongType' => [[TaxIdentifierTransformerInterface::KEY_TAX_IDENTIFIER_TYPE => 42], null, null, null];

        yield 'taxpayerIdWrongType' => [[TaxIdentifierTransformerInterface::KEY_TAXPAYER_ID => 42], null, null, null];
    }
}
