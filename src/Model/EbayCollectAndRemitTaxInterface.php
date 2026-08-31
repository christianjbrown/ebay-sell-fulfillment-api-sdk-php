<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface EbayCollectAndRemitTaxInterface
{
    public function getAmount(): ?AmountInterface;

    public function getCollectionMethod(): ?string;

    public function getEbayReference(): ?EbayTaxReferenceInterface;

    public function getTaxType(): ?string;

    public function setAmount(?AmountInterface $value): self;

    public function setCollectionMethod(?string $value): self;

    public function setEbayReference(?EbayTaxReferenceInterface $value): self;

    public function setTaxType(?string $value): self;
}
