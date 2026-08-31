<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PostSaleAuthenticationProgram;
use ChristianBrown\EBay\SellFulfillment\Model\PostSaleAuthenticationProgramInterface;

use function is_string;

final class PostSaleAuthenticationProgramTransformer implements PostSaleAuthenticationProgramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PostSaleAuthenticationProgramInterface
    {
        $postSaleAuthenticationProgram = new PostSaleAuthenticationProgram();

        self::applyOutcomeReason($postSaleAuthenticationProgram, $data);
        self::applyStatus($postSaleAuthenticationProgram, $data);

        return $postSaleAuthenticationProgram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOutcomeReason(PostSaleAuthenticationProgram $postSaleAuthenticationProgram, array $data): void
    {
        if (empty($data[self::KEY_OUTCOME_REASON])) {
            return;
        }
        if (!is_string($data[self::KEY_OUTCOME_REASON])) {
            return;
        }
        $postSaleAuthenticationProgram->setOutcomeReason($data[self::KEY_OUTCOME_REASON]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatus(PostSaleAuthenticationProgram $postSaleAuthenticationProgram, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $postSaleAuthenticationProgram->setStatus($data[self::KEY_STATUS]);
    }
}
