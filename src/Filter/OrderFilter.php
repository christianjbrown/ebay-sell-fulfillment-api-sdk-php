<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Filter;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

use function implode;
use function sprintf;

final class OrderFilter implements OrderFilterInterface
{
    private ?string $creationDateFrom = null;
    private ?string $creationDateTo = null;
    private ?string $lastModifiedDateFrom = null;
    private ?string $lastModifiedDateTo = null;

    /**
     * @var array<int, string>
     */
    private array $orderFulfillmentStatuses = [];

    public function getCreationDateFrom(): ?string
    {
        return $this->creationDateFrom;
    }

    public function getCreationDateTo(): ?string
    {
        return $this->creationDateTo;
    }

    public function getLastModifiedDateFrom(): ?string
    {
        return $this->lastModifiedDateFrom;
    }

    public function getLastModifiedDateTo(): ?string
    {
        return $this->lastModifiedDateTo;
    }

    /**
     * @return array<int, string>
     */
    public function getOrderFulfillmentStatuses(): array
    {
        return $this->orderFulfillmentStatuses;
    }

    public function setCreationDateFrom(?DateTimeInterface $value): OrderFilterInterface
    {
        $this->creationDateFrom = self::toUtcString($value);

        return $this;
    }

    public function setCreationDateTo(?DateTimeInterface $value): OrderFilterInterface
    {
        $this->creationDateTo = self::toUtcString($value);

        return $this;
    }

    public function setLastModifiedDateFrom(?DateTimeInterface $value): OrderFilterInterface
    {
        $this->lastModifiedDateFrom = self::toUtcString($value);

        return $this;
    }

    public function setLastModifiedDateTo(?DateTimeInterface $value): OrderFilterInterface
    {
        $this->lastModifiedDateTo = self::toUtcString($value);

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setOrderFulfillmentStatuses(array $value): OrderFilterInterface
    {
        $this->orderFulfillmentStatuses = $value;

        return $this;
    }

    public function toFilterString(): string
    {
        $filters = [];

        $filters = self::applyRange($filters, self::FILTER_NAME_CREATION_DATE, $this->creationDateFrom, $this->creationDateTo);
        $filters = self::applyRange($filters, self::FILTER_NAME_LAST_MODIFIED_DATE, $this->lastModifiedDateFrom, $this->lastModifiedDateTo);
        $filters = self::applyOrderFulfillmentStatuses($filters, $this->orderFulfillmentStatuses);

        return implode(self::FILTER_SEPARATOR, $filters);
    }

    /**
     * @phpstan-param array<int, string> $filters
     * @phpstan-param array<int, string> $statuses
     *
     * @return array<int, string>
     */
    private static function applyOrderFulfillmentStatuses(array $filters, array $statuses): array
    {
        if (empty($statuses)) {
            return $filters;
        }
        $set = sprintf(self::STATUS_SET_SPRINTF, implode(self::STATUS_SEPARATOR, $statuses));
        $filters[] = sprintf(self::FILTER_SPRINTF, self::FILTER_NAME_ORDER_FULFILLMENT_STATUS, $set);

        return $filters;
    }

    /**
     * @phpstan-param array<int, string> $filters
     *
     * @return array<int, string>
     */
    private static function applyRange(array $filters, string $name, ?string $from, ?string $to): array
    {
        $range = self::buildRange($from, $to);
        if (null === $range) {
            return $filters;
        }
        $filters[] = sprintf(self::FILTER_SPRINTF, $name, $range);

        return $filters;
    }

    private static function buildRange(?string $from, ?string $to): ?string
    {
        if (null === $from) {
            if (null === $to) {
                return null;
            }

            return sprintf(self::RANGE_SPRINTF, '', $to);
        }
        if (null === $to) {
            return sprintf(self::RANGE_SPRINTF, $from, '');
        }

        return sprintf(self::RANGE_SPRINTF, $from, $to);
    }

    private static function toUtcString(?DateTimeInterface $value): ?string
    {
        if (null === $value) {
            return null;
        }

        return DateTimeImmutable::createFromInterface($value)
            ->setTimezone(new DateTimeZone(self::TIME_ZONE_UTC))
            ->format(self::DATE_FORMAT);
    }
}
