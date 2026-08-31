<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeSummaryResponse;
use ChristianBrown\EBay\SellFulfillment\Model\DisputeSummaryResponseInterface;

use function is_array;
use function is_int;
use function is_string;

final class DisputeSummaryResponseTransformer implements DisputeSummaryResponseTransformerInterface
{
    private PaymentDisputeSummariesTransformerInterface $paymentDisputeSummariesTransformer;

    public function __construct(PaymentDisputeSummariesTransformerInterface $paymentDisputeSummariesTransformer)
    {
        $this->paymentDisputeSummariesTransformer = $paymentDisputeSummariesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DisputeSummaryResponseInterface
    {
        $disputeSummaryResponse = new DisputeSummaryResponse();

        self::applyHref($disputeSummaryResponse, $data);
        self::applyLimit($disputeSummaryResponse, $data);
        self::applyNext($disputeSummaryResponse, $data);
        self::applyOffset($disputeSummaryResponse, $data);
        $this->applyPaymentDisputeSummaries($disputeSummaryResponse, $data);
        self::applyPrev($disputeSummaryResponse, $data);
        self::applyTotal($disputeSummaryResponse, $data);

        return $disputeSummaryResponse;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHref(DisputeSummaryResponse $disputeSummaryResponse, array $data): void
    {
        if (empty($data[self::KEY_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_HREF])) {
            return;
        }
        $disputeSummaryResponse->setHref($data[self::KEY_HREF]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLimit(DisputeSummaryResponse $disputeSummaryResponse, array $data): void
    {
        if (!isset($data[self::KEY_LIMIT])) {
            return;
        }
        if (!is_int($data[self::KEY_LIMIT])) {
            return;
        }
        $disputeSummaryResponse->setLimit($data[self::KEY_LIMIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNext(DisputeSummaryResponse $disputeSummaryResponse, array $data): void
    {
        if (empty($data[self::KEY_NEXT])) {
            return;
        }
        if (!is_string($data[self::KEY_NEXT])) {
            return;
        }
        $disputeSummaryResponse->setNext($data[self::KEY_NEXT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOffset(DisputeSummaryResponse $disputeSummaryResponse, array $data): void
    {
        if (!isset($data[self::KEY_OFFSET])) {
            return;
        }
        if (!is_int($data[self::KEY_OFFSET])) {
            return;
        }
        $disputeSummaryResponse->setOffset($data[self::KEY_OFFSET]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPaymentDisputeSummaries(DisputeSummaryResponse $disputeSummaryResponse, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_DISPUTE_SUMMARIES])) {
            return;
        }
        if (!is_array($data[self::KEY_PAYMENT_DISPUTE_SUMMARIES])) {
            return;
        }
        $disputeSummaryResponse->setPaymentDisputeSummaries($this->paymentDisputeSummariesTransformer->transform($data[self::KEY_PAYMENT_DISPUTE_SUMMARIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPrev(DisputeSummaryResponse $disputeSummaryResponse, array $data): void
    {
        if (empty($data[self::KEY_PREV])) {
            return;
        }
        if (!is_string($data[self::KEY_PREV])) {
            return;
        }
        $disputeSummaryResponse->setPrev($data[self::KEY_PREV]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTotal(DisputeSummaryResponse $disputeSummaryResponse, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL])) {
            return;
        }
        if (!is_int($data[self::KEY_TOTAL])) {
            return;
        }
        $disputeSummaryResponse->setTotal($data[self::KEY_TOTAL]);
    }
}
