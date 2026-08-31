<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Filter;

use DateTimeInterface;

interface OrderFilterInterface
{
    public const string DATE_FORMAT = 'Y-m-d\TH:i:s.v\Z';
    public const string FILTER_NAME_CREATION_DATE = 'creationdate';
    public const string FILTER_NAME_LAST_MODIFIED_DATE = 'lastmodifieddate';
    public const string FILTER_NAME_ORDER_FULFILLMENT_STATUS = 'orderfulfillmentstatus';
    public const string FILTER_SEPARATOR = ',';
    public const string FILTER_SPRINTF = '%s:%s';

    /**
     * eBay only retains roughly two years of order history, so a creation-date
     * lower bound earlier than this many years ago returns nothing extra.
     */
    public const int MAX_HISTORY_YEARS = 2;
    public const string ORDER_FULFILLMENT_STATUS_FULFILLED = 'FULFILLED';
    public const string ORDER_FULFILLMENT_STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const string ORDER_FULFILLMENT_STATUS_NOT_STARTED = 'NOT_STARTED';
    public const string RANGE_SPRINTF = '[%s..%s]';
    public const string STATUS_SEPARATOR = '|';
    public const string STATUS_SET_SPRINTF = '{%s}';
    public const string TIME_ZONE_UTC = 'UTC';

    public function getCreationDateFrom(): ?string;

    public function getCreationDateTo(): ?string;

    public function getLastModifiedDateFrom(): ?string;

    public function getLastModifiedDateTo(): ?string;

    /**
     * @return array<int, string>
     */
    public function getOrderFulfillmentStatuses(): array;

    public function setCreationDateFrom(?DateTimeInterface $value): self;

    public function setCreationDateTo(?DateTimeInterface $value): self;

    public function setLastModifiedDateFrom(?DateTimeInterface $value): self;

    public function setLastModifiedDateTo(?DateTimeInterface $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setOrderFulfillmentStatuses(array $value): self;

    /**
     * Renders the `filter` query-string value `getOrders` expects, for example
     * `creationdate:[2026-01-01T00:00:00.000Z..],orderfulfillmentstatus:{NOT_STARTED|IN_PROGRESS}`.
     * Returns an empty string when nothing has been set.
     *
     * Note that eBay documents only two supported fulfillment-status
     * combinations, `{NOT_STARTED|IN_PROGRESS}` and `{FULFILLED|IN_PROGRESS}`,
     * and ignores `lastmodifieddate` whenever `creationdate` is also set.
     */
    public function toFilterString(): string;
}
