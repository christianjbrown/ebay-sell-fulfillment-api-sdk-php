<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Exception;

use ChristianBrown\EBay\SellFulfillment\Exception\MissingInputException;
use ChristianBrown\EBay\SellFulfillment\Exception\MissingInputExceptionInterface;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MissingInputException::class)]
final class MissingInputExceptionTest extends TestCase
{
    public function testIsAnInvalidArgumentExceptionImplementingItsInterface(): void
    {
        $exception = new MissingInputException('test-message');

        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertInstanceOf(MissingInputExceptionInterface::class, $exception);
        self::assertSame('test-message', $exception->getMessage());
    }
}
