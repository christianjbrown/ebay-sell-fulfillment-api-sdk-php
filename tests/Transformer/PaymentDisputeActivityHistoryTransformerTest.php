<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityHistory;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeActivityInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivitiesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityHistoryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityHistoryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentDisputeActivityHistory::class)]
#[CoversClass(PaymentDisputeActivityHistoryTransformer::class)]
final class PaymentDisputeActivityHistoryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $activityData = ['__activity__'];

        $activity = [self::createStub(PaymentDisputeActivityInterface::class)];

        $paymentDisputeActivitiesTransformer = self::createStub(PaymentDisputeActivitiesTransformerInterface::class);
        $paymentDisputeActivitiesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$activityData, $activity],
                ]
            );

        $data = [
            PaymentDisputeActivityHistoryTransformerInterface::KEY_ACTIVITY => $activityData,
        ];

        $transformer = new PaymentDisputeActivityHistoryTransformer($paymentDisputeActivitiesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($activity, $actual->getActivity());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformActivityNotSetCases')]
    public function testTransformActivityNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getActivity());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformActivityNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[PaymentDisputeActivityHistoryTransformerInterface::KEY_ACTIVITY => 'not-an-array']];
    }

    private function buildTransformer(): PaymentDisputeActivityHistoryTransformer
    {
        $paymentDisputeActivitiesTransformer = self::createStub(PaymentDisputeActivitiesTransformerInterface::class);

        return new PaymentDisputeActivityHistoryTransformer($paymentDisputeActivitiesTransformer);
    }
}
