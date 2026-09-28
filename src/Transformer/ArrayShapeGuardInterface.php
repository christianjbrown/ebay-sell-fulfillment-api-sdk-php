<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseExceptionInterface;

/**
 * The one check every collection transformer needs before it hands an
 * element to its singular transformer: that the element actually decoded to
 * an array.
 */
interface ArrayShapeGuardInterface
{
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @phpstan-assert array<mixed> $value
     *
     * @throws UnexpectedResponseExceptionInterface
     */
    public function assertArray(mixed $value, string $arrayName): void;
}
