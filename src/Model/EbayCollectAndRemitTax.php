<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class EbayCollectAndRemitTax implements EbayCollectAndRemitTaxInterface
{
    private ?AmountInterface $amount = null;
    private ?string $collectionMethod = null;
    private ?EbayTaxReferenceInterface $ebayReference = null;
    private ?string $taxType = null;

    public function getAmount(): ?AmountInterface
    {
        return $this->amount;
    }

    public function getCollectionMethod(): ?string
    {
        return $this->collectionMethod;
    }

    public function getEbayReference(): ?EbayTaxReferenceInterface
    {
        return $this->ebayReference;
    }

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setAmount(?AmountInterface $value): EbayCollectAndRemitTaxInterface
    {
        $this->amount = $value;

        return $this;
    }

    public function setCollectionMethod(?string $value): EbayCollectAndRemitTaxInterface
    {
        $this->collectionMethod = $value;

        return $this;
    }

    public function setEbayReference(?EbayTaxReferenceInterface $value): EbayCollectAndRemitTaxInterface
    {
        $this->ebayReference = $value;

        return $this;
    }

    public function setTaxType(?string $value): EbayCollectAndRemitTaxInterface
    {
        $this->taxType = $value;

        return $this;
    }
}
