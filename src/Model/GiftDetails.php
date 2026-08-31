<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class GiftDetails implements GiftDetailsInterface
{
    private ?string $message = null;
    private ?string $recipientEmail = null;
    private ?string $senderName = null;

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getRecipientEmail(): ?string
    {
        return $this->recipientEmail;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setMessage(?string $value): GiftDetailsInterface
    {
        $this->message = $value;

        return $this;
    }

    public function setRecipientEmail(?string $value): GiftDetailsInterface
    {
        $this->recipientEmail = $value;

        return $this;
    }

    public function setSenderName(?string $value): GiftDetailsInterface
    {
        $this->senderName = $value;

        return $this;
    }
}
