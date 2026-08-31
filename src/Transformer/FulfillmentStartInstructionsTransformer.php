<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstructionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class FulfillmentStartInstructionsTransformer implements FulfillmentStartInstructionsTransformerInterface
{
    private FulfillmentStartInstructionTransformerInterface $fulfillmentStartInstructionTransformer;

    public function __construct(FulfillmentStartInstructionTransformerInterface $fulfillmentStartInstructionTransformer)
    {
        $this->fulfillmentStartInstructionTransformer = $fulfillmentStartInstructionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, FulfillmentStartInstructionInterface>
     */
    public function transform(array $data): array
    {
        $fulfillmentStartInstructions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $fulfillmentStartInstructions[] = $this->fulfillmentStartInstructionTransformer->transform($value);
        }

        return $fulfillmentStartInstructions;
    }
}
