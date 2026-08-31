<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItem;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderLineItem::class)]
#[CoversClass(OrderLineItemTransformer::class)]
final class OrderLineItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            OrderLineItemTransformerInterface::KEY_ITEM_ID => 'test-itemId',
            OrderLineItemTransformerInterface::KEY_LINE_ITEM_ID => 'test-lineItemId',
        ];

        $transformer = new OrderLineItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-itemId', $actual->getItemId());
        self::assertSame('test-lineItemId', $actual->getLineItemId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedItemId, ?string $expectedLineItemId): void
    {
        $transformer = new OrderLineItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedItemId, $actual->getItemId());
        self::assertSame($expectedLineItemId, $actual->getLineItemId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'itemIdWrongType' => [[OrderLineItemTransformerInterface::KEY_ITEM_ID => 42], null, null];

        yield 'lineItemIdWrongType' => [[OrderLineItemTransformerInterface::KEY_LINE_ITEM_ID => 42], null, null];
    }
}
