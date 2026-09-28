<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToReleaseInterface;

use function array_values;
use function count;

final class SellerActionsToReleaseTransformer implements SellerActionsToReleaseTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private SellerActionToReleaseTransformerInterface $sellerActionToReleaseTransformer;

    public function __construct(SellerActionToReleaseTransformerInterface $sellerActionToReleaseTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->sellerActionToReleaseTransformer = $sellerActionToReleaseTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SellerActionToReleaseInterface>
     */
    public function transform(array $data): array
    {
        $sellerActionsToRelease = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $sellerActionsToRelease[] = $this->sellerActionToReleaseTransformer->transform($value);
        }

        return $sellerActionsToRelease;
    }
}
