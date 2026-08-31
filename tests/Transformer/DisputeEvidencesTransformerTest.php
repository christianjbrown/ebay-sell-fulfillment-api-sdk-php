<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\DisputeEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidencesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidencesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DisputeEvidencesTransformer::class)]
final class DisputeEvidencesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(DisputeEvidenceInterface::class);
        $second = self::createStub(DisputeEvidenceInterface::class);

        $disputeEvidenceTransformer = self::createStub(DisputeEvidenceTransformerInterface::class);
        $disputeEvidenceTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new DisputeEvidencesTransformer($disputeEvidenceTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new DisputeEvidencesTransformer(self::createStub(DisputeEvidenceTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new DisputeEvidencesTransformer(self::createStub(DisputeEvidenceTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DisputeEvidencesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DisputeEvidencesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
