<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FulfillmentStartInstructionInterface;

use function array_values;
use function count;

final class FulfillmentStartInstructionsTransformer implements FulfillmentStartInstructionsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private FulfillmentStartInstructionTransformerInterface $fulfillmentStartInstructionTransformer;

    public function __construct(FulfillmentStartInstructionTransformerInterface $fulfillmentStartInstructionTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->fulfillmentStartInstructionTransformer = $fulfillmentStartInstructionTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
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
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $fulfillmentStartInstructions[] = $this->fulfillmentStartInstructionTransformer->transform($value);
        }

        return $fulfillmentStartInstructions;
    }
}
