<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Exception;

use InvalidArgumentException;

final class MissingInputException extends InvalidArgumentException implements MissingInputExceptionInterface
{
}
