<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;

use function array_values;
use function count;

final class AppliedPromotionsTransformer implements AppliedPromotionsTransformerInterface
{
    private AppliedPromotionTransformerInterface $appliedPromotionTransformer;
    private ArrayShapeGuardInterface $arrayShapeGuard;

    public function __construct(AppliedPromotionTransformerInterface $appliedPromotionTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->appliedPromotionTransformer = $appliedPromotionTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AppliedPromotionInterface>
     */
    public function transform(array $data): array
    {
        $appliedPromotions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $appliedPromotions[] = $this->appliedPromotionTransformer->transform($value);
        }

        return $appliedPromotions;
    }
}
