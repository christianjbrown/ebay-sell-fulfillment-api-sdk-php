<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class IssueRefundRequest implements IssueRefundRequestInterface
{
    private ?string $comment = null;
    private ?SimpleAmountInterface $orderLevelRefundAmount = null;
    private ?string $reasonForRefund = null;

    /**
     * @var array<int, RefundItemInterface>
     */
    private array $refundItems = [];

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getOrderLevelRefundAmount(): ?SimpleAmountInterface
    {
        return $this->orderLevelRefundAmount;
    }

    public function getReasonForRefund(): ?string
    {
        return $this->reasonForRefund;
    }

    /**
     * @return array<int, RefundItemInterface>
     */
    public function getRefundItems(): array
    {
        return $this->refundItems;
    }

    public function setComment(?string $value): IssueRefundRequestInterface
    {
        $this->comment = $value;

        return $this;
    }

    public function setOrderLevelRefundAmount(?SimpleAmountInterface $value): IssueRefundRequestInterface
    {
        $this->orderLevelRefundAmount = $value;

        return $this;
    }

    public function setReasonForRefund(?string $value): IssueRefundRequestInterface
    {
        $this->reasonForRefund = $value;

        return $this;
    }

    /**
     * @param array<int, RefundItemInterface> $value
     */
    public function setRefundItems(array $value): IssueRefundRequestInterface
    {
        $this->refundItems = $value;

        return $this;
    }
}
