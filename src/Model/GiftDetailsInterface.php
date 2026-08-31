<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface GiftDetailsInterface
{
    public function getMessage(): ?string;

    public function getRecipientEmail(): ?string;

    public function getSenderName(): ?string;

    public function setMessage(?string $value): self;

    public function setRecipientEmail(?string $value): self;

    public function setSenderName(?string $value): self;
}
