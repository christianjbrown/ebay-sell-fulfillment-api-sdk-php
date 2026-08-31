<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface IssueRefundRequestInterface
{
    public function getComment(): ?string;

    public function getOrderLevelRefundAmount(): ?SimpleAmountInterface;

    public function getReasonForRefund(): ?string;

    /**
     * @return array<int, RefundItemInterface>
     */
    public function getRefundItems(): array;

    public function setComment(?string $value): self;

    public function setOrderLevelRefundAmount(?SimpleAmountInterface $value): self;

    public function setReasonForRefund(?string $value): self;

    /**
     * @param array<int, RefundItemInterface> $value
     */
    public function setRefundItems(array $value): self;
}
