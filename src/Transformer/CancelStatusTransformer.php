<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelStatus;
use ChristianBrown\EBay\SellFulfillment\Model\CancelStatusInterface;

use function is_array;
use function is_string;

final class CancelStatusTransformer implements CancelStatusTransformerInterface
{
    private CancelRequestsTransformerInterface $cancelRequestsTransformer;

    public function __construct(CancelRequestsTransformerInterface $cancelRequestsTransformer)
    {
        $this->cancelRequestsTransformer = $cancelRequestsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CancelStatusInterface
    {
        $cancelStatus = new CancelStatus();

        self::applyCancelledDate($cancelStatus, $data);
        $this->applyCancelRequests($cancelStatus, $data);
        self::applyCancelState($cancelStatus, $data);

        return $cancelStatus;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelledDate(CancelStatus $cancelStatus, array $data): void
    {
        if (empty($data[self::KEY_CANCELLED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCELLED_DATE])) {
            return;
        }
        $cancelStatus->setCancelledDate($data[self::KEY_CANCELLED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCancelRequests(CancelStatus $cancelStatus, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_REQUESTS])) {
            return;
        }
        if (!is_array($data[self::KEY_CANCEL_REQUESTS])) {
            return;
        }
        $cancelStatus->setCancelRequests($this->cancelRequestsTransformer->transform($data[self::KEY_CANCEL_REQUESTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelState(CancelStatus $cancelStatus, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCEL_STATE])) {
            return;
        }
        $cancelStatus->setCancelState($data[self::KEY_CANCEL_STATE]);
    }
}
