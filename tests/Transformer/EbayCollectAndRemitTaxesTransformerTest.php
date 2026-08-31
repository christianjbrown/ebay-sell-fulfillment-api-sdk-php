<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTaxInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(EbayCollectAndRemitTaxesTransformer::class)]
final class EbayCollectAndRemitTaxesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(EbayCollectAndRemitTaxInterface::class);
        $second = self::createStub(EbayCollectAndRemitTaxInterface::class);

        $ebayCollectAndRemitTaxTransformer = self::createStub(EbayCollectAndRemitTaxTransformerInterface::class);
        $ebayCollectAndRemitTaxTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new EbayCollectAndRemitTaxesTransformer($ebayCollectAndRemitTaxTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new EbayCollectAndRemitTaxesTransformer(self::createStub(EbayCollectAndRemitTaxTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new EbayCollectAndRemitTaxesTransformer(self::createStub(EbayCollectAndRemitTaxTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(EbayCollectAndRemitTaxesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, EbayCollectAndRemitTaxesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
