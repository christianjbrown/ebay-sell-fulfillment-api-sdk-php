<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Buyer;
use ChristianBrown\EBay\SellFulfillment\Model\BuyerInterface;

use function is_array;
use function is_string;

final class BuyerTransformer implements BuyerTransformerInterface
{
    private ExtendedContactTransformerInterface $extendedContactTransformer;
    private TaxAddressTransformerInterface $taxAddressTransformer;
    private TaxIdentifierTransformerInterface $taxIdentifierTransformer;

    public function __construct(ExtendedContactTransformerInterface $extendedContactTransformer, TaxAddressTransformerInterface $taxAddressTransformer, TaxIdentifierTransformerInterface $taxIdentifierTransformer)
    {
        $this->extendedContactTransformer = $extendedContactTransformer;
        $this->taxAddressTransformer = $taxAddressTransformer;
        $this->taxIdentifierTransformer = $taxIdentifierTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BuyerInterface
    {
        $buyer = new Buyer();

        $this->applyBuyerRegistrationAddress($buyer, $data);
        $this->applyTaxAddress($buyer, $data);
        $this->applyTaxIdentifier($buyer, $data);
        self::applyUsername($buyer, $data);

        return $buyer;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBuyerRegistrationAddress(Buyer $buyer, array $data): void
    {
        if (empty($data[self::KEY_BUYER_REGISTRATION_ADDRESS])) {
            return;
        }
        if (!is_array($data[self::KEY_BUYER_REGISTRATION_ADDRESS])) {
            return;
        }
        $buyer->setBuyerRegistrationAddress($this->extendedContactTransformer->transform($data[self::KEY_BUYER_REGISTRATION_ADDRESS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTaxAddress(Buyer $buyer, array $data): void
    {
        if (empty($data[self::KEY_TAX_ADDRESS])) {
            return;
        }
        if (!is_array($data[self::KEY_TAX_ADDRESS])) {
            return;
        }
        $buyer->setTaxAddress($this->taxAddressTransformer->transform($data[self::KEY_TAX_ADDRESS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTaxIdentifier(Buyer $buyer, array $data): void
    {
        if (empty($data[self::KEY_TAX_IDENTIFIER])) {
            return;
        }
        if (!is_array($data[self::KEY_TAX_IDENTIFIER])) {
            return;
        }
        $buyer->setTaxIdentifier($this->taxIdentifierTransformer->transform($data[self::KEY_TAX_IDENTIFIER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUsername(Buyer $buyer, array $data): void
    {
        if (empty($data[self::KEY_USERNAME])) {
            return;
        }
        if (!is_string($data[self::KEY_USERNAME])) {
            return;
        }
        $buyer->setUsername($data[self::KEY_USERNAME]);
    }
}
