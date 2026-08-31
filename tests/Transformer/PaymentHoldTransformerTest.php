<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentHold;
use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToReleaseInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionsToReleaseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentHold::class)]
#[CoversClass(PaymentHoldTransformer::class)]
final class PaymentHoldTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $holdAmountData = ['__holdAmount__'];
        $sellerActionsToReleaseData = ['__sellerActionsToRelease__'];

        $holdAmount = self::createStub(AmountInterface::class);
        $sellerActionsToRelease = [self::createStub(SellerActionToReleaseInterface::class)];

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$holdAmountData, $holdAmount],
                ]
            );
        $sellerActionsToReleaseTransformer = self::createStub(SellerActionsToReleaseTransformerInterface::class);
        $sellerActionsToReleaseTransformer->method('transform')
            ->willReturnMap(
                [
                    [$sellerActionsToReleaseData, $sellerActionsToRelease],
                ]
            );

        $data = [
            PaymentHoldTransformerInterface::KEY_EXPECTED_RELEASE_DATE => 'test-expectedReleaseDate',
            PaymentHoldTransformerInterface::KEY_HOLD_AMOUNT => $holdAmountData,
            PaymentHoldTransformerInterface::KEY_HOLD_REASON => 'test-holdReason',
            PaymentHoldTransformerInterface::KEY_HOLD_STATE => 'test-holdState',
            PaymentHoldTransformerInterface::KEY_RELEASE_DATE => 'test-releaseDate',
            PaymentHoldTransformerInterface::KEY_SELLER_ACTIONS_TO_RELEASE => $sellerActionsToReleaseData,
        ];

        $transformer = new PaymentHoldTransformer($amountTransformer, $sellerActionsToReleaseTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-expectedReleaseDate', $actual->getExpectedReleaseDate());
        self::assertSame($holdAmount, $actual->getHoldAmount());
        self::assertSame('test-holdReason', $actual->getHoldReason());
        self::assertSame('test-holdState', $actual->getHoldState());
        self::assertSame('test-releaseDate', $actual->getReleaseDate());
        self::assertSame($sellerActionsToRelease, $actual->getSellerActionsToRelease());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformHoldAmountNotSetCases')]
    public function testTransformHoldAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getHoldAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformHoldAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentHoldTransformerInterface::KEY_HOLD_AMOUNT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedExpectedReleaseDate, ?string $expectedHoldReason, ?string $expectedHoldState, ?string $expectedReleaseDate): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedExpectedReleaseDate, $actual->getExpectedReleaseDate());
        self::assertSame($expectedHoldReason, $actual->getHoldReason());
        self::assertSame($expectedHoldState, $actual->getHoldState());
        self::assertSame($expectedReleaseDate, $actual->getReleaseDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'expectedReleaseDateWrongType' => [[PaymentHoldTransformerInterface::KEY_EXPECTED_RELEASE_DATE => 42], null, null, null, null];

        yield 'holdReasonWrongType' => [[PaymentHoldTransformerInterface::KEY_HOLD_REASON => 42], null, null, null, null];

        yield 'holdStateWrongType' => [[PaymentHoldTransformerInterface::KEY_HOLD_STATE => 42], null, null, null, null];

        yield 'releaseDateWrongType' => [[PaymentHoldTransformerInterface::KEY_RELEASE_DATE => 42], null, null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSellerActionsToReleaseNotSetCases')]
    public function testTransformSellerActionsToReleaseNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getSellerActionsToRelease());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSellerActionsToReleaseNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentHoldTransformerInterface::KEY_SELLER_ACTIONS_TO_RELEASE => 'not-an-array']];
    }

    private function buildTransformer(): PaymentHoldTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $sellerActionsToReleaseTransformer = self::createStub(SellerActionsToReleaseTransformerInterface::class);

        return new PaymentHoldTransformer($amountTransformer, $sellerActionsToReleaseTransformer);
    }
}
