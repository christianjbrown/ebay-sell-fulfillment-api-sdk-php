<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;

use function is_array;
use function sprintf;

final class ArrayShapeGuard implements ArrayShapeGuardInterface
{
    /**
     * @phpstan-assert array<mixed> $value
     */
    public function assertArray(mixed $value, string $arrayName): void
    {
        if (is_array($value)) {
            return;
        }

        throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, $arrayName));
    }
}
