<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\NameValuePair;
use ChristianBrown\EBay\SellFulfillment\Model\NameValuePairInterface;

use function is_string;

final class NameValuePairTransformer implements NameValuePairTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NameValuePairInterface
    {
        $nameValuePair = new NameValuePair();

        self::applyName($nameValuePair, $data);
        self::applyValue($nameValuePair, $data);

        return $nameValuePair;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(NameValuePair $nameValuePair, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $nameValuePair->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(NameValuePair $nameValuePair, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $nameValuePair->setValue($data[self::KEY_VALUE]);
    }
}
