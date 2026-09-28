<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\DisputeEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
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

        $transformer = new DisputeEvidencesTransformer($disputeEvidenceTransformer, self::passingArrayShapeGuard());

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new DisputeEvidencesTransformer(self::createStub(DisputeEvidenceTransformerInterface::class), self::passingArrayShapeGuard());

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $exception = new UnexpectedResponseException(sprintf(DisputeEvidencesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DisputeEvidencesTransformerInterface::ARRAY_NAME));

        $arrayShapeGuard = self::createMock(ArrayShapeGuardInterface::class);
        $arrayShapeGuard->expects(self::once())->method('assertArray')
            ->with('not-an-array', DisputeEvidencesTransformerInterface::ARRAY_NAME)
            ->willThrowException($exception);

        $transformer = new DisputeEvidencesTransformer(self::createStub(DisputeEvidenceTransformerInterface::class), $arrayShapeGuard);

        $this->expectException(UnexpectedResponseException::class);

        $transformer->transform(['not-an-array']);
    }

    private static function passingArrayShapeGuard(): ArrayShapeGuardInterface
    {
        return self::createStub(ArrayShapeGuardInterface::class);
    }
}
