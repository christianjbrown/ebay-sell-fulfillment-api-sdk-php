<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PostSaleAuthenticationProgramInterface;

interface PostSaleAuthenticationProgramTransformerInterface
{
    public const string KEY_OUTCOME_REASON = 'outcomeReason';
    public const string KEY_STATUS = 'status';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PostSaleAuthenticationProgramInterface;
}
