<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ProgramInterface
{
    public function getAuthenticityVerification(): ?PostSaleAuthenticationProgramInterface;

    public function getEbayInternationalShipping(): ?EbayInternationalShippingInterface;

    public function getEbayShipping(): ?EbayShippingInterface;

    public function getEbayVault(): ?EbayVaultProgramInterface;

    public function getFulfillmentProgram(): ?EbayFulfillmentProgramInterface;

    public function setAuthenticityVerification(?PostSaleAuthenticationProgramInterface $value): self;

    public function setEbayInternationalShipping(?EbayInternationalShippingInterface $value): self;

    public function setEbayShipping(?EbayShippingInterface $value): self;

    public function setEbayVault(?EbayVaultProgramInterface $value): self;

    public function setFulfillmentProgram(?EbayFulfillmentProgramInterface $value): self;
}
