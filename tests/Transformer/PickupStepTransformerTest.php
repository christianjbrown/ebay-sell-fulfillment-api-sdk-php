<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PickupStep;
use ChristianBrown\EBay\SellFulfillment\Transformer\PickupStepTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PickupStepTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PickupStep::class)]
#[CoversClass(PickupStepTransformer::class)]
final class PickupStepTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PickupStepTransformerInterface::KEY_MERCHANT_LOCATION_KEY => 'test-merchantLocationKey',
        ];

        $transformer = new PickupStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-merchantLocationKey', $actual->getMerchantLocationKey());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedMerchantLocationKey): void
    {
        $transformer = new PickupStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedMerchantLocationKey, $actual->getMerchantLocationKey());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'merchantLocationKeyWrongType' => [[PickupStepTransformerInterface::KEY_MERCHANT_LOCATION_KEY => 42], null];
    }
}
