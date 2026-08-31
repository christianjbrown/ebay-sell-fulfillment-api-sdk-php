<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Filter;

use ChristianBrown\EBay\SellFulfillment\Filter\OrderFilter;
use ChristianBrown\EBay\SellFulfillment\Filter\OrderFilterInterface;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderFilter::class)]
final class OrderFilterTest extends TestCase
{
    public function testToFilterStringWithBothDateBoundsAndStatuses(): void
    {
        $filter = (new OrderFilter())
            ->setCreationDateFrom(new DateTimeImmutable('2026-01-01 00:00:00', new DateTimeZone('UTC')))
            ->setCreationDateTo(new DateTimeImmutable('2026-02-01 00:00:00', new DateTimeZone('UTC')))
            ->setLastModifiedDateFrom(new DateTimeImmutable('2026-03-01 00:00:00', new DateTimeZone('UTC')))
            ->setLastModifiedDateTo(new DateTimeImmutable('2026-04-01 00:00:00', new DateTimeZone('UTC')))
            ->setOrderFulfillmentStatuses(
                [
                    OrderFilterInterface::ORDER_FULFILLMENT_STATUS_NOT_STARTED,
                    OrderFilterInterface::ORDER_FULFILLMENT_STATUS_IN_PROGRESS,
                ]
            );

        $expected = 'creationdate:[2026-01-01T00:00:00.000Z..2026-02-01T00:00:00.000Z],'
        .'lastmodifieddate:[2026-03-01T00:00:00.000Z..2026-04-01T00:00:00.000Z],'
        .'orderfulfillmentstatus:{NOT_STARTED|IN_PROGRESS}';

        self::assertSame($expected, $filter->toFilterString());
        self::assertSame('2026-01-01T00:00:00.000Z', $filter->getCreationDateFrom());
        self::assertSame('2026-02-01T00:00:00.000Z', $filter->getCreationDateTo());
        self::assertSame('2026-03-01T00:00:00.000Z', $filter->getLastModifiedDateFrom());
        self::assertSame('2026-04-01T00:00:00.000Z', $filter->getLastModifiedDateTo());
        self::assertSame(
            [
                OrderFilterInterface::ORDER_FULFILLMENT_STATUS_NOT_STARTED,
                OrderFilterInterface::ORDER_FULFILLMENT_STATUS_IN_PROGRESS,
            ],
            $filter->getOrderFulfillmentStatuses()
        );
    }

    public function testToFilterStringWithEmptyFilter(): void
    {
        $filter = new OrderFilter();

        self::assertSame('', $filter->toFilterString());
        self::assertNull($filter->getCreationDateFrom());
        self::assertNull($filter->getCreationDateTo());
        self::assertNull($filter->getLastModifiedDateFrom());
        self::assertNull($filter->getLastModifiedDateTo());
        self::assertSame([], $filter->getOrderFulfillmentStatuses());
    }

    public function testToFilterStringWithLowerBoundOnly(): void
    {
        $filter = (new OrderFilter())
            ->setCreationDateFrom(new DateTimeImmutable('2026-01-01 00:00:00', new DateTimeZone('UTC')));

        self::assertSame('creationdate:[2026-01-01T00:00:00.000Z..]', $filter->toFilterString());
    }

    public function testToFilterStringWithNulledDatesIsEmpty(): void
    {
        $filter = (new OrderFilter())
            ->setCreationDateFrom(new DateTimeImmutable('2026-01-01 00:00:00', new DateTimeZone('UTC')))
            ->setCreationDateFrom(null);

        self::assertSame('', $filter->toFilterString());
    }

    public function testToFilterStringWithUpperBoundOnly(): void
    {
        $filter = (new OrderFilter())
            ->setCreationDateTo(new DateTimeImmutable('2026-02-01 00:00:00', new DateTimeZone('UTC')));

        self::assertSame('creationdate:[..2026-02-01T00:00:00.000Z]', $filter->toFilterString());
    }

    public function testToUtcStringConvertsFromAnotherTimeZone(): void
    {
        $filter = (new OrderFilter())
            ->setCreationDateFrom(new DateTimeImmutable('2026-06-01 12:00:00', new DateTimeZone('Europe/London')));

        self::assertSame('2026-06-01T11:00:00.000Z', $filter->getCreationDateFrom());
    }
}
