<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstructionInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(FulfillmentStartInstructionsTransformer::class)]
final class FulfillmentStartInstructionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-1'], ['test-2']];

        $first = self::createStub(FulfillmentStartInstructionInterface::class);
        $second = self::createStub(FulfillmentStartInstructionInterface::class);

        $fulfillmentStartInstructionTransformer = self::createStub(FulfillmentStartInstructionTransformerInterface::class);
        $fulfillmentStartInstructionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-1'], $first],
                    [['test-2'], $second],
                ]
            );

        $transformer = new FulfillmentStartInstructionsTransformer($fulfillmentStartInstructionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new FulfillmentStartInstructionsTransformer(self::createStub(FulfillmentStartInstructionTransformerInterface::class));

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArrayElement(): void
    {
        $transformer = new FulfillmentStartInstructionsTransformer(self::createStub(FulfillmentStartInstructionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(FulfillmentStartInstructionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, FulfillmentStartInstructionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
