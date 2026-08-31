<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class AppliedPromotionsTransformer implements AppliedPromotionsTransformerInterface
{
    private AppliedPromotionTransformerInterface $appliedPromotionTransformer;

    public function __construct(AppliedPromotionTransformerInterface $appliedPromotionTransformer)
    {
        $this->appliedPromotionTransformer = $appliedPromotionTransformer;
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
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $appliedPromotions[] = $this->appliedPromotionTransformer->transform($value);
        }

        return $appliedPromotions;
    }
}
