<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuard;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuardInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ArrayShapeGuard::class)]
final class ArrayShapeGuardTest extends TestCase
{
    public function testAssertArrayDoesNothingForAnArray(): void
    {
        $guard = new ArrayShapeGuard();

        $guard->assertArray(self::asMixed(['test']), 'widgets');

        $this->expectNotToPerformAssertions();
    }

    public function testAssertArrayThrowsForANonArray(): void
    {
        $guard = new ArrayShapeGuard();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ArrayShapeGuardInterface::UNEXPECTED_ARRAY_SPRINTF, 'widgets'));

        $guard->assertArray(self::asMixed('not-an-array'), 'widgets');
    }

    private static function asMixed(mixed $value): mixed
    {
        return $value;
    }
}
