<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Program implements ProgramInterface
{
    private ?PostSaleAuthenticationProgramInterface $authenticityVerification = null;
    private ?EbayInternationalShippingInterface $ebayInternationalShipping = null;
    private ?EbayShippingInterface $ebayShipping = null;
    private ?EbayVaultProgramInterface $ebayVault = null;
    private ?EbayFulfillmentProgramInterface $fulfillmentProgram = null;

    public function getAuthenticityVerification(): ?PostSaleAuthenticationProgramInterface
    {
        return $this->authenticityVerification;
    }

    public function getEbayInternationalShipping(): ?EbayInternationalShippingInterface
    {
        return $this->ebayInternationalShipping;
    }

    public function getEbayShipping(): ?EbayShippingInterface
    {
        return $this->ebayShipping;
    }

    public function getEbayVault(): ?EbayVaultProgramInterface
    {
        return $this->ebayVault;
    }

    public function getFulfillmentProgram(): ?EbayFulfillmentProgramInterface
    {
        return $this->fulfillmentProgram;
    }

    public function setAuthenticityVerification(?PostSaleAuthenticationProgramInterface $value): ProgramInterface
    {
        $this->authenticityVerification = $value;

        return $this;
    }

    public function setEbayInternationalShipping(?EbayInternationalShippingInterface $value): ProgramInterface
    {
        $this->ebayInternationalShipping = $value;

        return $this;
    }

    public function setEbayShipping(?EbayShippingInterface $value): ProgramInterface
    {
        $this->ebayShipping = $value;

        return $this;
    }

    public function setEbayVault(?EbayVaultProgramInterface $value): ProgramInterface
    {
        $this->ebayVault = $value;

        return $this;
    }

    public function setFulfillmentProgram(?EbayFulfillmentProgramInterface $value): ProgramInterface
    {
        $this->fulfillmentProgram = $value;

        return $this;
    }
}
