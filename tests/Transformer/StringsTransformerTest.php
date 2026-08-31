<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Transformer\StringsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\StringsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(StringsTransformer::class)]
final class StringsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $transformer = new StringsTransformer();

        self::assertSame(['alpha', 'beta'], $transformer->transform(['alpha', 'beta']));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new StringsTransformer();

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonStringElement(): void
    {
        $transformer = new StringsTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(StringsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StringsTransformerInterface::ARRAY_NAME));

        $transformer->transform([42]);
    }
}
