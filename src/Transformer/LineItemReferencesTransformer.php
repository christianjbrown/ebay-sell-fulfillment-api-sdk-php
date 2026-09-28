<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

use function array_values;
use function count;

final class LineItemReferencesTransformer implements LineItemReferencesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private LineItemReferenceTransformerInterface $lineItemReferenceTransformer;

    public function __construct(LineItemReferenceTransformerInterface $lineItemReferenceTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->lineItemReferenceTransformer = $lineItemReferenceTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LineItemReferenceInterface>
     */
    public function transform(array $data): array
    {
        $lineItemReferences = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $lineItemReferences[] = $this->lineItemReferenceTransformer->transform($value);
        }

        return $lineItemReferences;
    }
}
