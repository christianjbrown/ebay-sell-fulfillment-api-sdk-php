<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstructionInterface;

interface FulfillmentStartInstructionsTransformerInterface
{
    public const string ARRAY_NAME = 'fulfillment_start_instruction';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, FulfillmentStartInstructionInterface>
     */
    public function transform(array $data): array;
}
