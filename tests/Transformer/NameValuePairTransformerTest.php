<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\NameValuePair;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(NameValuePair::class)]
#[CoversClass(NameValuePairTransformer::class)]
final class NameValuePairTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            NameValuePairTransformerInterface::KEY_NAME => 'test-name',
            NameValuePairTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new NameValuePairTransformer();

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
        $transformer = new NameValuePairTransformer();

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

        yield 'nameWrongType' => [[NameValuePairTransformerInterface::KEY_NAME => 42], null, null];

        yield 'valueWrongType' => [[NameValuePairTransformerInterface::KEY_VALUE => 42], null, null];
    }
}
