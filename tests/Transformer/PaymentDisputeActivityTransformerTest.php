<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivity;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentDisputeActivity::class)]
#[CoversClass(PaymentDisputeActivityTransformer::class)]
final class PaymentDisputeActivityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PaymentDisputeActivityTransformerInterface::KEY_ACTIVITY_DATE => 'test-activityDate',
            PaymentDisputeActivityTransformerInterface::KEY_ACTIVITY_TYPE => 'test-activityType',
            PaymentDisputeActivityTransformerInterface::KEY_ACTOR => 'test-actor',
        ];

        $transformer = new PaymentDisputeActivityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-activityDate', $actual->getActivityDate());
        self::assertSame('test-activityType', $actual->getActivityType());
        self::assertSame('test-actor', $actual->getActor());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedActivityDate, ?string $expectedActivityType, ?string $expectedActor): void
    {
        $transformer = new PaymentDisputeActivityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedActivityDate, $actual->getActivityDate());
        self::assertSame($expectedActivityType, $actual->getActivityType());
        self::assertSame($expectedActor, $actual->getActor());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'activityDateWrongType' => [[PaymentDisputeActivityTransformerInterface::KEY_ACTIVITY_DATE => 42], null, null, null];

        yield 'activityTypeWrongType' => [[PaymentDisputeActivityTransformerInterface::KEY_ACTIVITY_TYPE => 42], null, null, null];

        yield 'actorWrongType' => [[PaymentDisputeActivityTransformerInterface::KEY_ACTOR => 42], null, null, null];
    }
}
