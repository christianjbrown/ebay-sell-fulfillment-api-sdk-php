<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Exception;

use RuntimeException;

final class UnexpectedResponseException extends RuntimeException implements UnexpectedResponseExceptionInterface
{
}
