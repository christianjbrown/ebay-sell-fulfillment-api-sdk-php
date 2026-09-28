<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Property;
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertyTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertyTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Property::class)]
#[CoversClass(PropertyTransformer::class)]
final class PropertyTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PropertyTransformerInterface::KEY_PROPERTY_DISPLAY_NAME => 'test-propertyDisplayName',
            PropertyTransformerInterface::KEY_PROPERTY_NAME => 'test-propertyName',
            PropertyTransformerInterface::KEY_PROPERTY_VALUE => 'test-propertyValue',
        ];

        $transformer = new PropertyTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-propertyDisplayName', $actual->getPropertyDisplayName());
        self::assertSame('test-propertyName', $actual->getPropertyName());
        self::assertSame('test-propertyValue', $actual->getPropertyValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedPropertyDisplayName, ?string $expectedPropertyName, ?string $expectedPropertyValue): void
    {
        $transformer = new PropertyTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedPropertyDisplayName, $actual->getPropertyDisplayName());
        self::assertSame($expectedPropertyName, $actual->getPropertyName());
        self::assertSame($expectedPropertyValue, $actual->getPropertyValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'propertyDisplayNameWrongType' => [[PropertyTransformerInterface::KEY_PROPERTY_DISPLAY_NAME => 42], null, null, null];

        yield 'propertyNameWrongType' => [[PropertyTransformerInterface::KEY_PROPERTY_NAME => 42], null, null, null];

        yield 'propertyValueWrongType' => [[PropertyTransformerInterface::KEY_PROPERTY_VALUE => 42], null, null, null];
    }
}
