<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequest;
use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EvidenceRequest::class)]
#[CoversClass(EvidenceRequestTransformer::class)]
final class EvidenceRequestTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $lineItemsData = ['__lineItems__'];

        $lineItems = [self::createStub(OrderLineItemInterface::class)];

        $orderLineItemsTransformer = self::createStub(OrderLineItemsTransformerInterface::class);
        $orderLineItemsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$lineItemsData, $lineItems],
                ]
            );

        $data = [
            EvidenceRequestTransformerInterface::KEY_EVIDENCE_ID => 'test-evidenceId',
            EvidenceRequestTransformerInterface::KEY_EVIDENCE_TYPE => 'test-evidenceType',
            EvidenceRequestTransformerInterface::KEY_LINE_ITEMS => $lineItemsData,
            EvidenceRequestTransformerInterface::KEY_REQUEST_DATE => 'test-requestDate',
            EvidenceRequestTransformerInterface::KEY_RESPOND_BY_DATE => 'test-respondByDate',
        ];

        $transformer = new EvidenceRequestTransformer($orderLineItemsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-evidenceId', $actual->getEvidenceId());
        self::assertSame('test-evidenceType', $actual->getEvidenceType());
        self::assertSame($lineItems, $actual->getLineItems());
        self::assertSame('test-requestDate', $actual->getRequestDate());
        self::assertSame('test-respondByDate', $actual->getRespondByDate());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLineItemsNotSetCases')]
    public function testTransformLineItemsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getLineItems());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLineItemsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[EvidenceRequestTransformerInterface::KEY_LINE_ITEMS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedEvidenceId, ?string $expectedEvidenceType, ?string $expectedRequestDate, ?string $expectedRespondByDate): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedEvidenceId, $actual->getEvidenceId());
        self::assertSame($expectedEvidenceType, $actual->getEvidenceType());
        self::assertSame($expectedRequestDate, $actual->getRequestDate());
        self::assertSame($expectedRespondByDate, $actual->getRespondByDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null];

        yield 'evidenceIdWrongType' => [[EvidenceRequestTransformerInterface::KEY_EVIDENCE_ID => 42], null, null, null, null];

        yield 'evidenceTypeWrongType' => [[EvidenceRequestTransformerInterface::KEY_EVIDENCE_TYPE => 42], null, null, null, null];

        yield 'requestDateWrongType' => [[EvidenceRequestTransformerInterface::KEY_REQUEST_DATE => 42], null, null, null, null];

        yield 'respondByDateWrongType' => [[EvidenceRequestTransformerInterface::KEY_RESPOND_BY_DATE => 42], null, null, null, null];
    }

    private function buildTransformer(): EvidenceRequestTransformer
    {
        $orderLineItemsTransformer = self::createStub(OrderLineItemsTransformerInterface::class);

        return new EvidenceRequestTransformer($orderLineItemsTransformer);
    }
}
