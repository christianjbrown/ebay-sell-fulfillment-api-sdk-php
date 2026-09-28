<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\Charge;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargeTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Charge::class)]
#[CoversClass(ChargeTransformer::class)]
final class ChargeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $amountData = ['__amount__'];

        $amount = self::createStub(AmountInterface::class);

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$amountData, $amount],
                ]
            );

        $data = [
            ChargeTransformerInterface::KEY_AMOUNT => $amountData,
            ChargeTransformerInterface::KEY_CHARGE_TYPE => 'test-chargeType',
        ];

        $transformer = new ChargeTransformer($amountTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($amount, $actual->getAmount());
        self::assertSame('test-chargeType', $actual->getChargeType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformAmountNotSetCases')]
    public function testTransformAmountNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getAmount());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformAmountNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ChargeTransformerInterface::KEY_AMOUNT => 'not-an-array']];
    }

    public function testTransformChargeTypeWrongType(): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform([ChargeTransformerInterface::KEY_CHARGE_TYPE => 42])->getChargeType());
    }

    private function buildTransformer(): ChargeTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);

        return new ChargeTransformer($amountTransformer);
    }
}
