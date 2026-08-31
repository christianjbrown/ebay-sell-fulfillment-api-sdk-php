<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameter;
use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameterInterface;

use function is_string;

final class ErrorParameterTransformer implements ErrorParameterTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ErrorParameterInterface
    {
        $errorParameter = new ErrorParameter();

        self::applyName($errorParameter, $data);
        self::applyValue($errorParameter, $data);

        return $errorParameter;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(ErrorParameter $errorParameter, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $errorParameter->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(ErrorParameter $errorParameter, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $errorParameter->setValue($data[self::KEY_VALUE]);
    }
}
