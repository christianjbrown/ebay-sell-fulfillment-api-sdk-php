<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayTaxReference;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayTaxReferenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayTaxReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EbayTaxReference::class)]
#[CoversClass(EbayTaxReferenceTransformer::class)]
final class EbayTaxReferenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EbayTaxReferenceTransformerInterface::KEY_NAME => 'test-name',
            EbayTaxReferenceTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new EbayTaxReferenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedName, ?string $expectedValue): void
    {
        $transformer = new EbayTaxReferenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedValue, $actual->getValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'nameWrongType' => [[EbayTaxReferenceTransformerInterface::KEY_NAME => 42], null, null];

        yield 'valueWrongType' => [[EbayTaxReferenceTransformerInterface::KEY_VALUE => 42], null, null];
    }
}
