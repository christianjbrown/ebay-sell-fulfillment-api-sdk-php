<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayFulfillmentProgram;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayFulfillmentProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayFulfillmentProgramTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EbayFulfillmentProgram::class)]
#[CoversClass(EbayFulfillmentProgramTransformer::class)]
final class EbayFulfillmentProgramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EbayFulfillmentProgramTransformerInterface::KEY_FULFILLED_BY => 'test-fulfilledBy',
        ];

        $transformer = new EbayFulfillmentProgramTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-fulfilledBy', $actual->getFulfilledBy());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedFulfilledBy): void
    {
        $transformer = new EbayFulfillmentProgramTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedFulfilledBy, $actual->getFulfilledBy());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'fulfilledByWrongType' => [[EbayFulfillmentProgramTransformerInterface::KEY_FULFILLED_BY => 42], null];
    }
}
