<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Program;
use ChristianBrown\EBay\SellFulfillment\Model\ProgramInterface;

use function is_array;

final class ProgramTransformer implements ProgramTransformerInterface
{
    private EbayFulfillmentProgramTransformerInterface $ebayFulfillmentProgramTransformer;
    private EbayInternationalShippingTransformerInterface $ebayInternationalShippingTransformer;
    private EbayShippingTransformerInterface $ebayShippingTransformer;
    private EbayVaultProgramTransformerInterface $ebayVaultProgramTransformer;
    private PostSaleAuthenticationProgramTransformerInterface $postSaleAuthenticationProgramTransformer;

    public function __construct(EbayFulfillmentProgramTransformerInterface $ebayFulfillmentProgramTransformer, EbayInternationalShippingTransformerInterface $ebayInternationalShippingTransformer, EbayShippingTransformerInterface $ebayShippingTransformer, EbayVaultProgramTransformerInterface $ebayVaultProgramTransformer, PostSaleAuthenticationProgramTransformerInterface $postSaleAuthenticationProgramTransformer)
    {
        $this->ebayFulfillmentProgramTransformer = $ebayFulfillmentProgramTransformer;
        $this->ebayInternationalShippingTransformer = $ebayInternationalShippingTransformer;
        $this->ebayShippingTransformer = $ebayShippingTransformer;
        $this->ebayVaultProgramTransformer = $ebayVaultProgramTransformer;
        $this->postSaleAuthenticationProgramTransformer = $postSaleAuthenticationProgramTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ProgramInterface
    {
        $program = new Program();

        $this->applyAuthenticityVerification($program, $data);
        $this->applyEbayInternationalShipping($program, $data);
        $this->applyEbayShipping($program, $data);
        $this->applyEbayVault($program, $data);
        $this->applyFulfillmentProgram($program, $data);

        return $program;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAuthenticityVerification(Program $program, array $data): void
    {
        if (empty($data[self::KEY_AUTHENTICITY_VERIFICATION])) {
            return;
        }
        if (!is_array($data[self::KEY_AUTHENTICITY_VERIFICATION])) {
            return;
        }
        $program->setAuthenticityVerification($this->postSaleAuthenticationProgramTransformer->transform($data[self::KEY_AUTHENTICITY_VERIFICATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEbayInternationalShipping(Program $program, array $data): void
    {
        if (empty($data[self::KEY_EBAY_INTERNATIONAL_SHIPPING])) {
            return;
        }
        if (!is_array($data[self::KEY_EBAY_INTERNATIONAL_SHIPPING])) {
            return;
        }
        $program->setEbayInternationalShipping($this->ebayInternationalShippingTransformer->transform($data[self::KEY_EBAY_INTERNATIONAL_SHIPPING]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEbayShipping(Program $program, array $data): void
    {
        if (empty($data[self::KEY_EBAY_SHIPPING])) {
            return;
        }
        if (!is_array($data[self::KEY_EBAY_SHIPPING])) {
            return;
        }
        $program->setEbayShipping($this->ebayShippingTransformer->transform($data[self::KEY_EBAY_SHIPPING]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEbayVault(Program $program, array $data): void
    {
        if (empty($data[self::KEY_EBAY_VAULT])) {
            return;
        }
        if (!is_array($data[self::KEY_EBAY_VAULT])) {
            return;
        }
        $program->setEbayVault($this->ebayVaultProgramTransformer->transform($data[self::KEY_EBAY_VAULT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFulfillmentProgram(Program $program, array $data): void
    {
        if (empty($data[self::KEY_FULFILLMENT_PROGRAM])) {
            return;
        }
        if (!is_array($data[self::KEY_FULFILLMENT_PROGRAM])) {
            return;
        }
        $program->setFulfillmentProgram($this->ebayFulfillmentProgramTransformer->transform($data[self::KEY_FULFILLMENT_PROGRAM]));
    }
}
