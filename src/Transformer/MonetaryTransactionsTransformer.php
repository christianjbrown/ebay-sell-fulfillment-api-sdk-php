<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransactionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class MonetaryTransactionsTransformer implements MonetaryTransactionsTransformerInterface
{
    private MonetaryTransactionTransformerInterface $monetaryTransactionTransformer;

    public function __construct(MonetaryTransactionTransformerInterface $monetaryTransactionTransformer)
    {
        $this->monetaryTransactionTransformer = $monetaryTransactionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, MonetaryTransactionInterface>
     */
    public function transform(array $data): array
    {
        $monetaryTransactions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $monetaryTransactions[] = $this->monetaryTransactionTransformer->transform($value);
        }

        return $monetaryTransactions;
    }
}
