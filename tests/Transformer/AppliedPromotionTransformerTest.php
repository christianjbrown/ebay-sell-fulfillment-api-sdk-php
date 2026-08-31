<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotion;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppliedPromotion::class)]
#[CoversClass(AppliedPromotionTransformer::class)]
final class AppliedPromotionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $discountAmountData = ['__discountAmount__'];

        $discountAmount = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$discountAmountData, $discountAmount],
                ]
            );

        $data = [
            AppliedPromotionTransformerInterface::KEY_DESCRIPTION => 'test-description',
            AppliedPromotionTransformerInterface::KEY_DISCOUNT_AMOUNT => $discountAmountData,
            AppliedPromotionTransformerInterface::KEY_PROMOTION_ID => 'test-promotionId',
        ];

        $transformer = new AppliedPromotionTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-description', $actual->getDescription());
        self::assertSame($discountAmount, $actual->getDiscountAmount());
        self::assertSame('test-promotionId', $actual->getPromotionId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformDiscountAmountNotSetCases')]
    public function testTransformDiscountAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getDiscountAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformDiscountAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[AppliedPromotionTransformerInterface::KEY_DISCOUNT_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedDescription, ?string $expectedPromotionId): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedDescription, $actual->getDescription());
        self::assertSame($expectedPromotionId, $actual->getPromotionId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'descriptionWrongType' => [[AppliedPromotionTransformerInterface::KEY_DESCRIPTION => 42], null, null];

        yield 'promotionIdWrongType' => [[AppliedPromotionTransformerInterface::KEY_PROMOTION_ID => 42], null, null];
    }

    private function buildTransformer(): AppliedPromotionTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new AppliedPromotionTransformer($amountTransformer);
    }
}
