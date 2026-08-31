<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelRequest;
use ChristianBrown\EBay\SellFulfillment\Model\CancelRequestInterface;

use function is_string;

final class CancelRequestTransformer implements CancelRequestTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CancelRequestInterface
    {
        $cancelRequest = new CancelRequest();

        self::applyCancelCompletedDate($cancelRequest, $data);
        self::applyCancelInitiator($cancelRequest, $data);
        self::applyCancelReason($cancelRequest, $data);
        self::applyCancelRequestedDate($cancelRequest, $data);
        self::applyCancelRequestId($cancelRequest, $data);
        self::applyCancelRequestState($cancelRequest, $data);

        return $cancelRequest;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelCompletedDate(CancelRequest $cancelRequest, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_COMPLETED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCEL_COMPLETED_DATE])) {
            return;
        }
        $cancelRequest->setCancelCompletedDate($data[self::KEY_CANCEL_COMPLETED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelInitiator(CancelRequest $cancelRequest, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_INITIATOR])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCEL_INITIATOR])) {
            return;
        }
        $cancelRequest->setCancelInitiator($data[self::KEY_CANCEL_INITIATOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelReason(CancelRequest $cancelRequest, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_REASON])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCEL_REASON])) {
            return;
        }
        $cancelRequest->setCancelReason($data[self::KEY_CANCEL_REASON]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelRequestedDate(CancelRequest $cancelRequest, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_REQUESTED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCEL_REQUESTED_DATE])) {
            return;
        }
        $cancelRequest->setCancelRequestedDate($data[self::KEY_CANCEL_REQUESTED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelRequestId(CancelRequest $cancelRequest, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_REQUEST_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCEL_REQUEST_ID])) {
            return;
        }
        $cancelRequest->setCancelRequestId($data[self::KEY_CANCEL_REQUEST_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCancelRequestState(CancelRequest $cancelRequest, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_REQUEST_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CANCEL_REQUEST_STATE])) {
            return;
        }
        $cancelRequest->setCancelRequestState($data[self::KEY_CANCEL_REQUEST_STATE]);
    }
}
