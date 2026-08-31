<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorInterface;

interface ErrorTransformerInterface
{
    public const string KEY_CATEGORY = 'category';
    public const string KEY_DOMAIN = 'domain';
    public const string KEY_ERROR_ID = 'errorId';
    public const string KEY_INPUT_REF_IDS = 'inputRefIds';
    public const string KEY_LONG_MESSAGE = 'longMessage';
    public const string KEY_MESSAGE = 'message';
    public const string KEY_OUTPUT_REF_IDS = 'outputRefIds';
    public const string KEY_PARAMETERS = 'parameters';
    public const string KEY_SUBDOMAIN = 'subdomain';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ErrorInterface;
}
