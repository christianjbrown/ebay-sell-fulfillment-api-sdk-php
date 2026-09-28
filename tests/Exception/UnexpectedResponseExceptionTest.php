<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Exception;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseExceptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(UnexpectedResponseException::class)]
final class UnexpectedResponseExceptionTest extends TestCase
{
    public function testIsARuntimeExceptionImplementingItsInterface(): void
    {
        $exception = new UnexpectedResponseException('test-message');

        self::assertInstanceOf(RuntimeException::class, $exception);
        self::assertInstanceOf(UnexpectedResponseExceptionInterface::class, $exception);
        self::assertSame('test-message', $exception->getMessage());
    }
}
