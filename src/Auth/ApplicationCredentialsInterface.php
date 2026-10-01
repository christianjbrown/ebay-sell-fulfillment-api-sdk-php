<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Auth;

/**
 * The identity a client authenticates as: the eBay App ID and Cert ID, and
 * the marketplace the requests are made against.
 */
interface ApplicationCredentialsInterface
{
    public function getClientId(): string;

    public function getClientSecret(): string;

    public function getMarketplaceId(): string;
}
