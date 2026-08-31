<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequestInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(EvidenceRequestsTransformer::class)]
final class EvidenceRequestsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(EvidenceRequestInterface::class);
        $second = self::createStub(EvidenceRequestInterface::class);

        $evidenceRequestTransformer = self::createStub(EvidenceRequestTransformerInterface::class);
        $evidenceRequestTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new EvidenceRequestsTransformer($evidenceRequestTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new EvidenceRequestsTransformer(self::createStub(EvidenceRequestTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new EvidenceRequestsTransformer(self::createStub(EvidenceRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(EvidenceRequestsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, EvidenceRequestsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
