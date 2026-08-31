<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentPagedCollection;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentPagedCollectionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentPagedCollectionTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShippingFulfillmentPagedCollection::class)]
#[CoversClass(ShippingFulfillmentPagedCollectionTransformer::class)]
final class ShippingFulfillmentPagedCollectionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $fulfillmentsData = ['__fulfillments__'];
        $warningsData = ['__warnings__'];

        $fulfillments = [self::createStub(ShippingFulfillmentInterface::class)];
        $warnings = [self::createStub(ErrorInterface::class)];

        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$warningsData, $warnings],
                ]
            );
        $shippingFulfillmentsTransformer = self::createStub(ShippingFulfillmentsTransformerInterface::class);
        $shippingFulfillmentsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$fulfillmentsData, $fulfillments],
                ]
            );

        $data = [
            ShippingFulfillmentPagedCollectionTransformerInterface::KEY_FULFILLMENTS => $fulfillmentsData,
            ShippingFulfillmentPagedCollectionTransformerInterface::KEY_TOTAL => 42,
            ShippingFulfillmentPagedCollectionTransformerInterface::KEY_WARNINGS => $warningsData,
        ];

        $transformer = new ShippingFulfillmentPagedCollectionTransformer($errorsTransformer, $shippingFulfillmentsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($fulfillments, $actual->getFulfillments());
        self::assertSame(42, $actual->getTotal());
        self::assertSame($warnings, $actual->getWarnings());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFulfillmentsNotSetCases')]
    public function testTransformFulfillmentsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getFulfillments());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFulfillmentsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ShippingFulfillmentPagedCollectionTransformerInterface::KEY_FULFILLMENTS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?int $expectedTotal): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedTotal, $actual->getTotal());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?int}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'totalZero' => [[ShippingFulfillmentPagedCollectionTransformerInterface::KEY_TOTAL => 0], 0];

        yield 'totalWrongType' => [[ShippingFulfillmentPagedCollectionTransformerInterface::KEY_TOTAL => 'not-int'], null];
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

        yield 'nonArray' => [[ShippingFulfillmentPagedCollectionTransformerInterface::KEY_WARNINGS => 'not-an-array']];
    }

    private function buildTransformer(): ShippingFulfillmentPagedCollectionTransformer
    {
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $shippingFulfillmentsTransformer = self::createStub(ShippingFulfillmentsTransformerInterface::class);

        return new ShippingFulfillmentPagedCollectionTransformer($errorsTransformer, $shippingFulfillmentsTransformer);
    }
}
