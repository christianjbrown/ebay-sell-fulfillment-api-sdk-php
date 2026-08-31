<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransaction;
use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransactionInterface;

use function is_array;
use function is_string;

final class MonetaryTransactionTransformer implements MonetaryTransactionTransformerInterface
{
    private DisputeAmountTransformerInterface $disputeAmountTransformer;

    public function __construct(DisputeAmountTransformerInterface $disputeAmountTransformer)
    {
        $this->disputeAmountTransformer = $disputeAmountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MonetaryTransactionInterface
    {
        $monetaryTransaction = new MonetaryTransaction();

        $this->applyAmount($monetaryTransaction, $data);
        self::applyDate($monetaryTransaction, $data);
        self::applyReason($monetaryTransaction, $data);
        self::applyType($monetaryTransaction, $data);

        return $monetaryTransaction;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(MonetaryTransaction $monetaryTransaction, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $monetaryTransaction->setAmount($this->disputeAmountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDate(MonetaryTransaction $monetaryTransaction, array $data): void
    {
        if (empty($data[self::KEY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_DATE])) {
            return;
        }
        $monetaryTransaction->setDate($data[self::KEY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReason(MonetaryTransaction $monetaryTransaction, array $data): void
    {
        if (empty($data[self::KEY_REASON])) {
            return;
        }
        if (!is_string($data[self::KEY_REASON])) {
            return;
        }
        $monetaryTransaction->setReason($data[self::KEY_REASON]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(MonetaryTransaction $monetaryTransaction, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $monetaryTransaction->setType($data[self::KEY_TYPE]);
    }
}
