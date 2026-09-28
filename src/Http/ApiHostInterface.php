<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Http;

/**
 * The three hosts eBay's Sell Fulfillment API is spread across: order and
 * shipping fulfillment calls go to `api.ebay.com`, every payment dispute call
 * goes to `apiz.ebay.com`, and the OAuth token endpoint is its own URL under
 * `api.ebay.com`. Overriding all three is what lets the SDK target eBay's
 * sandbox (`api.sandbox.ebay.com` / `apiz.sandbox.ebay.com`).
 */
interface ApiHostInterface
{
    public const string DEFAULT_API_URL = 'https://api.ebay.com';
    public const string DEFAULT_APIZ_URL = 'https://apiz.ebay.com';
    public const string DEFAULT_OAUTH_TOKEN_URL = 'https://api.ebay.com/identity/v1/oauth2/token';

    /**
     * Base URL for order and shipping fulfillment calls.
     */
    public function getApiUrl(): string;

    /**
     * Base URL for payment dispute calls.
     */
    public function getApizUrl(): string;

    public function getOAuthTokenUrl(): string;
}
