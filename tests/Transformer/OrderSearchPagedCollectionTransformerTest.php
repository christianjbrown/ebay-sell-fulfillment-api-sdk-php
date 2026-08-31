<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderSearchPagedCollection;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderSearchPagedCollectionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderSearchPagedCollectionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrdersTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderSearchPagedCollection::class)]
#[CoversClass(OrderSearchPagedCollectionTransformer::class)]
final class OrderSearchPagedCollectionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $ordersData = ['__orders__'];
        $warningsData = ['__warnings__'];

        $orders = [self::createStub(OrderInterface::class)];
        $warnings = [self::createStub(ErrorInterface::class)];

        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$warningsData, $warnings],
                ]
            );
        $ordersTransformer = self::createStub(OrdersTransformerInterface::class);
        $ordersTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ordersData, $orders],
                ]
            );

        $data = [
            OrderSearchPagedCollectionTransformerInterface::KEY_HREF => 'test-href',
            OrderSearchPagedCollectionTransformerInterface::KEY_LIMIT => 42,
            OrderSearchPagedCollectionTransformerInterface::KEY_NEXT => 'test-next',
            OrderSearchPagedCollectionTransformerInterface::KEY_OFFSET => 42,
            OrderSearchPagedCollectionTransformerInterface::KEY_ORDERS => $ordersData,
            OrderSearchPagedCollectionTransformerInterface::KEY_PREV => 'test-prev',
            OrderSearchPagedCollectionTransformerInterface::KEY_TOTAL => 42,
            OrderSearchPagedCollectionTransformerInterface::KEY_WARNINGS => $warningsData,
        ];

        $transformer = new OrderSearchPagedCollectionTransformer($errorsTransformer, $ordersTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-href', $actual->getHref());
        self::assertSame(42, $actual->getLimit());
        self::assertSame('test-next', $actual->getNext());
        self::assertSame(42, $actual->getOffset());
        self::assertSame($orders, $actual->getOrders());
        self::assertSame('test-prev', $actual->getPrev());
        self::assertSame(42, $actual->getTotal());
        self::assertSame($warnings, $actual->getWarnings());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOrdersNotSetCases')]
    public function testTransformOrdersNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getOrders());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformOrdersNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderSearchPagedCollectionTransformerInterface::KEY_ORDERS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedHref, ?int $expectedLimit, ?string $expectedNext, ?int $expectedOffset, ?string $expectedPrev, ?int $expectedTotal): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedHref, $actual->getHref());
        self::assertSame($expectedLimit, $actual->getLimit());
        self::assertSame($expectedNext, $actual->getNext());
        self::assertSame($expectedOffset, $actual->getOffset());
        self::assertSame($expectedPrev, $actual->getPrev());
        self::assertSame($expectedTotal, $actual->getTotal());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?int, ?string, ?int, ?string, ?int}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null];

        yield 'hrefWrongType' => [[OrderSearchPagedCollectionTransformerInterface::KEY_HREF => 42], null, null, null, null, null, null];

        yield 'limitZero' => [[OrderSearchPagedCollectionTransformerInterface::KEY_LIMIT => 0], null, 0, null, null, null, null];

        yield 'limitWrongType' => [[OrderSearchPagedCollectionTransformerInterface::KEY_LIMIT => 'not-int'], null, null, null, null, null, null];

        yield 'nextWrongType' => [[OrderSearchPagedCollectionTransformerInterface::KEY_NEXT => 42], null, null, null, null, null, null];

        yield 'offsetZero' => [[OrderSearchPagedCollectionTransformerInterface::KEY_OFFSET => 0], null, null, null, 0, null, null];

        yield 'offsetWrongType' => [[OrderSearchPagedCollectionTransformerInterface::KEY_OFFSET => 'not-int'], null, null, null, null, null, null];

        yield 'prevWrongType' => [[OrderSearchPagedCollectionTransformerInterface::KEY_PREV => 42], null, null, null, null, null, null];

        yield 'totalZero' => [[OrderSearchPagedCollectionTransformerInterface::KEY_TOTAL => 0], null, null, null, null, null, 0];

        yield 'totalWrongType' => [[OrderSearchPagedCollectionTransformerInterface::KEY_TOTAL => 'not-int'], null, null, null, null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformWarningsNotSetCases')]
    public function testTransformWarningsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getWarnings());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformWarningsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[OrderSearchPagedCollectionTransformerInterface::KEY_WARNINGS => 'not-an-array']];
    }

    private function buildTransformer(): OrderSearchPagedCollectionTransformer
    {
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $ordersTransformer = self::createStub(OrdersTransformerInterface::class);

        return new OrderSearchPagedCollectionTransformer($errorsTransformer, $ordersTransformer);
    }
}
