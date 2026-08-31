<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayVaultProgram;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayVaultProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayVaultProgramTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EbayVaultProgram::class)]
#[CoversClass(EbayVaultProgramTransformer::class)]
final class EbayVaultProgramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EbayVaultProgramTransformerInterface::KEY_FULFILLMENT_TYPE => 'test-fulfillmentType',
        ];

        $transformer = new EbayVaultProgramTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-fulfillmentType', $actual->getFulfillmentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedFulfillmentType): void
    {
        $transformer = new EbayVaultProgramTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedFulfillmentType, $actual->getFulfillmentType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'fulfillmentTypeWrongType' => [[EbayVaultProgramTransformerInterface::KEY_FULFILLMENT_TYPE => 42], null];
    }
}
