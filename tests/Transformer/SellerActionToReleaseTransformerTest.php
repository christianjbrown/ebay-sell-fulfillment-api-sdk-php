<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToRelease;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionToReleaseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionToReleaseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SellerActionToRelease::class)]
#[CoversClass(SellerActionToReleaseTransformer::class)]
final class SellerActionToReleaseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SellerActionToReleaseTransformerInterface::KEY_SELLER_ACTION_TO_RELEASE => 'test-sellerActionToRelease',
        ];

        $transformer = new SellerActionToReleaseTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-sellerActionToRelease', $actual->getSellerActionToRelease());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedSellerActionToRelease): void
    {
        $transformer = new SellerActionToReleaseTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedSellerActionToRelease, $actual->getSellerActionToRelease());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'sellerActionToReleaseWrongType' => [[SellerActionToReleaseTransformerInterface::KEY_SELLER_ACTION_TO_RELEASE => 42], null];
    }
}
