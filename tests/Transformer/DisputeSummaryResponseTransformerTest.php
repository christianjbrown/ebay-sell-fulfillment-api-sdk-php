<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeSummaryResponse;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeSummaryInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeSummaryResponseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeSummaryResponseTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummariesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DisputeSummaryResponse::class)]
#[CoversClass(DisputeSummaryResponseTransformer::class)]
final class DisputeSummaryResponseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $paymentDisputeSummariesData = ['__paymentDisputeSummaries__'];

        $paymentDisputeSummaries = [self::createStub(PaymentDisputeSummaryInterface::class)];

        $paymentDisputeSummariesTransformer = self::createStub(PaymentDisputeSummariesTransformerInterface::class);
        $paymentDisputeSummariesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$paymentDisputeSummariesData, $paymentDisputeSummaries],
                ]
            );

        $data = [
            DisputeSummaryResponseTransformerInterface::KEY_HREF => 'test-href',
            DisputeSummaryResponseTransformerInterface::KEY_LIMIT => 42,
            DisputeSummaryResponseTransformerInterface::KEY_NEXT => 'test-next',
            DisputeSummaryResponseTransformerInterface::KEY_OFFSET => 42,
            DisputeSummaryResponseTransformerInterface::KEY_PAYMENT_DISPUTE_SUMMARIES => $paymentDisputeSummariesData,
            DisputeSummaryResponseTransformerInterface::KEY_PREV => 'test-prev',
            DisputeSummaryResponseTransformerInterface::KEY_TOTAL => 42,
        ];

        $transformer = new DisputeSummaryResponseTransformer($paymentDisputeSummariesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-href', $actual->getHref());
        self::assertSame(42, $actual->getLimit());
        self::assertSame('test-next', $actual->getNext());
        self::assertSame(42, $actual->getOffset());
        self::assertSame($paymentDisputeSummaries, $actual->getPaymentDisputeSummaries());
        self::assertSame('test-prev', $actual->getPrev());
        self::assertSame(42, $actual->getTotal());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPaymentDisputeSummariesNotSetCases')]
    public function testTransformPaymentDisputeSummariesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getPaymentDisputeSummaries());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPaymentDisputeSummariesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[DisputeSummaryResponseTransformerInterface::KEY_PAYMENT_DISPUTE_SUMMARIES => 'not-an-array']];
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

        yield 'hrefWrongType' => [[DisputeSummaryResponseTransformerInterface::KEY_HREF => 42], null, null, null, null, null, null];

        yield 'limitZero' => [[DisputeSummaryResponseTransformerInterface::KEY_LIMIT => 0], null, 0, null, null, null, null];

        yield 'limitWrongType' => [[DisputeSummaryResponseTransformerInterface::KEY_LIMIT => 'not-int'], null, null, null, null, null, null];

        yield 'nextWrongType' => [[DisputeSummaryResponseTransformerInterface::KEY_NEXT => 42], null, null, null, null, null, null];

        yield 'offsetZero' => [[DisputeSummaryResponseTransformerInterface::KEY_OFFSET => 0], null, null, null, 0, null, null];

        yield 'offsetWrongType' => [[DisputeSummaryResponseTransformerInterface::KEY_OFFSET => 'not-int'], null, null, null, null, null, null];

        yield 'prevWrongType' => [[DisputeSummaryResponseTransformerInterface::KEY_PREV => 42], null, null, null, null, null, null];

        yield 'totalZero' => [[DisputeSummaryResponseTransformerInterface::KEY_TOTAL => 0], null, null, null, null, null, 0];

        yield 'totalWrongType' => [[DisputeSummaryResponseTransformerInterface::KEY_TOTAL => 'not-int'], null, null, null, null, null, null];
    }

    private function buildTransformer(): DisputeSummaryResponseTransformer
    {
        $paymentDisputeSummariesTransformer = self::createStub(PaymentDisputeSummariesTransformerInterface::class);

        return new DisputeSummaryResponseTransformer($paymentDisputeSummariesTransformer);
    }
}
