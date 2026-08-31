<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeResponse;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddEvidencePaymentDisputeResponseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddEvidencePaymentDisputeResponseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AddEvidencePaymentDisputeResponse::class)]
#[CoversClass(AddEvidencePaymentDisputeResponseTransformer::class)]
final class AddEvidencePaymentDisputeResponseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AddEvidencePaymentDisputeResponseTransformerInterface::KEY_EVIDENCE_ID => 'test-evidenceId',
        ];

        $transformer = new AddEvidencePaymentDisputeResponseTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-evidenceId', $actual->getEvidenceId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedEvidenceId): void
    {
        $transformer = new AddEvidencePaymentDisputeResponseTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedEvidenceId, $actual->getEvidenceId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'evidenceIdWrongType' => [[AddEvidencePaymentDisputeResponseTransformerInterface::KEY_EVIDENCE_ID => 42], null];
    }
}
