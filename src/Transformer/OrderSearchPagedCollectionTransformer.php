<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\OrderSearchPagedCollection;
use ChristianBrown\EBay\SellFulfillment\Model\OrderSearchPagedCollectionInterface;

use function is_array;
use function is_int;
use function is_string;

final class OrderSearchPagedCollectionTransformer implements OrderSearchPagedCollectionTransformerInterface
{
    private ErrorsTransformerInterface $errorsTransformer;
    private OrdersTransformerInterface $ordersTransformer;

    public function __construct(ErrorsTransformerInterface $errorsTransformer, OrdersTransformerInterface $ordersTransformer)
    {
        $this->errorsTransformer = $errorsTransformer;
        $this->ordersTransformer = $ordersTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderSearchPagedCollectionInterface
    {
        $orderSearchPagedCollection = new OrderSearchPagedCollection();

        self::applyHref($orderSearchPagedCollection, $data);
        self::applyLimit($orderSearchPagedCollection, $data);
        self::applyNext($orderSearchPagedCollection, $data);
        self::applyOffset($orderSearchPagedCollection, $data);
        $this->applyOrders($orderSearchPagedCollection, $data);
        self::applyPrev($orderSearchPagedCollection, $data);
        self::applyTotal($orderSearchPagedCollection, $data);
        $this->applyWarnings($orderSearchPagedCollection, $data);

        return $orderSearchPagedCollection;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHref(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_HREF])) {
            return;
        }
        $orderSearchPagedCollection->setHref($data[self::KEY_HREF]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLimit(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (!isset($data[self::KEY_LIMIT])) {
            return;
        }
        if (!is_int($data[self::KEY_LIMIT])) {
            return;
        }
        $orderSearchPagedCollection->setLimit($data[self::KEY_LIMIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNext(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_NEXT])) {
            return;
        }
        if (!is_string($data[self::KEY_NEXT])) {
            return;
        }
        $orderSearchPagedCollection->setNext($data[self::KEY_NEXT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOffset(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (!isset($data[self::KEY_OFFSET])) {
            return;
        }
        if (!is_int($data[self::KEY_OFFSET])) {
            return;
        }
        $orderSearchPagedCollection->setOffset($data[self::KEY_OFFSET]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOrders(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_ORDERS])) {
            return;
        }
        if (!is_array($data[self::KEY_ORDERS])) {
            return;
        }
        $orderSearchPagedCollection->setOrders($this->ordersTransformer->transform($data[self::KEY_ORDERS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPrev(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_PREV])) {
            return;
        }
        if (!is_string($data[self::KEY_PREV])) {
            return;
        }
        $orderSearchPagedCollection->setPrev($data[self::KEY_PREV]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTotal(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL])) {
            return;
        }
        if (!is_int($data[self::KEY_TOTAL])) {
            return;
        }
        $orderSearchPagedCollection->setTotal($data[self::KEY_TOTAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(OrderSearchPagedCollection $orderSearchPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_WARNINGS])) {
            return;
        }
        $orderSearchPagedCollection->setWarnings($this->errorsTransformer->transform($data[self::KEY_WARNINGS]));
    }
}
