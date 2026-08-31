<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayInternationalShipping;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayInternationalShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayInternationalShippingTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EbayInternationalShipping::class)]
#[CoversClass(EbayInternationalShippingTransformer::class)]
final class EbayInternationalShippingTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EbayInternationalShippingTransformerInterface::KEY_RETURNS_MANAGED_BY => 'test-returnsManagedBy',
        ];

        $transformer = new EbayInternationalShippingTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-returnsManagedBy', $actual->getReturnsManagedBy());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedReturnsManagedBy): void
    {
        $transformer = new EbayInternationalShippingTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedReturnsManagedBy, $actual->getReturnsManagedBy());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'returnsManagedByWrongType' => [[EbayInternationalShippingTransformerInterface::KEY_RETURNS_MANAGED_BY => 42], null];
    }
}
