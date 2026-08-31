<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReference;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineItemReference::class)]
#[CoversClass(LineItemReferenceTransformer::class)]
final class LineItemReferenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LineItemReferenceTransformerInterface::KEY_LINE_ITEM_ID => 'test-lineItemId',
            LineItemReferenceTransformerInterface::KEY_QUANTITY => 42,
        ];

        $transformer = new LineItemReferenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-lineItemId', $actual->getLineItemId());
        self::assertSame(42, $actual->getQuantity());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedLineItemId, ?int $expectedQuantity): void
    {
        $transformer = new LineItemReferenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedLineItemId, $actual->getLineItemId());
        self::assertSame($expectedQuantity, $actual->getQuantity());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?int}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'lineItemIdWrongType' => [[LineItemReferenceTransformerInterface::KEY_LINE_ITEM_ID => 42], null, null];

        yield 'quantityZero' => [[LineItemReferenceTransformerInterface::KEY_QUANTITY => 0], null, 0];

        yield 'quantityWrongType' => [[LineItemReferenceTransformerInterface::KEY_QUANTITY => 'not-int'], null, null];
    }
}
