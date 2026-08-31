<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameter;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParameterTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ErrorParameter::class)]
#[CoversClass(ErrorParameterTransformer::class)]
final class ErrorParameterTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ErrorParameterTransformerInterface::KEY_NAME => 'test-name',
            ErrorParameterTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new ErrorParameterTransformer();

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
        $transformer = new ErrorParameterTransformer();

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

        yield 'nameWrongType' => [[ErrorParameterTransformerInterface::KEY_NAME => 42], null, null];

        yield 'valueWrongType' => [[ErrorParameterTransformerInterface::KEY_VALUE => 42], null, null];
    }
}
