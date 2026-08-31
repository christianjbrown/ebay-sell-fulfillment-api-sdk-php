<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayShipping;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayShippingTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EbayShipping::class)]
#[CoversClass(EbayShippingTransformer::class)]
final class EbayShippingTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EbayShippingTransformerInterface::KEY_SHIPPING_LABEL_PROVIDED_BY => 'test-shippingLabelProvidedBy',
        ];

        $transformer = new EbayShippingTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-shippingLabelProvidedBy', $actual->getShippingLabelProvidedBy());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedShippingLabelProvidedBy): void
    {
        $transformer = new EbayShippingTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedShippingLabelProvidedBy, $actual->getShippingLabelProvidedBy());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'shippingLabelProvidedByWrongType' => [[EbayShippingTransformerInterface::KEY_SHIPPING_LABEL_PROVIDED_BY => 42], null];
    }
}
