<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\MonetaryTransactionInterface;

use function array_values;
use function count;

final class MonetaryTransactionsTransformer implements MonetaryTransactionsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private MonetaryTransactionTransformerInterface $monetaryTransactionTransformer;

    public function __construct(MonetaryTransactionTransformerInterface $monetaryTransactionTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->monetaryTransactionTransformer = $monetaryTransactionTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
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
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $monetaryTransactions[] = $this->monetaryTransactionTransformer->transform($value);
        }

        return $monetaryTransactions;
    }
}
