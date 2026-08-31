<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\TaxInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TaxesTransformer::class)]
final class TaxesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(TaxInterface::class);
        $second = self::createStub(TaxInterface::class);

        $taxTransformer = self::createStub(TaxTransformerInterface::class);
        $taxTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new TaxesTransformer($taxTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new TaxesTransformer(self::createStub(TaxTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new TaxesTransformer(self::createStub(TaxTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(TaxesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, TaxesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
