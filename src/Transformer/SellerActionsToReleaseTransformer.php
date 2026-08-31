<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\SellerActionToReleaseInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class SellerActionsToReleaseTransformer implements SellerActionsToReleaseTransformerInterface
{
    private SellerActionToReleaseTransformerInterface $sellerActionToReleaseTransformer;

    public function __construct(SellerActionToReleaseTransformerInterface $sellerActionToReleaseTransformer)
    {
        $this->sellerActionToReleaseTransformer = $sellerActionToReleaseTransformer;
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
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $sellerActionsToRelease[] = $this->sellerActionToReleaseTransformer->transform($value);
        }

        return $sellerActionsToRelease;
    }
}
