<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Auth;

use ChristianBrown\OAuth2Client\Model\Exception\BadResponsePayloadFieldExceptionInterface;
use ChristianBrown\OAuth2Client\Model\Exception\InvalidGrantExceptionInterface;
use ChristianBrown\OAuth2Client\Model\Exception\RequestExceptionInterface;

interface CredentialsInterface
{
    public const string AUTHORIZATION_HEADER_VALUE_SPRINTF = 'Bearer %s';
    public const string HEADER_KEY_ACCEPT = 'Accept';
    public const string HEADER_KEY_AUTHORIZATION = 'Authorization';
    public const string HEADER_KEY_CONTENT_TYPE = 'Content-Type';
    public const string HEADER_KEY_MARKETPLACE_ID = 'X-EBAY-C-MARKETPLACE-ID';
    public const string HEADER_VALUE_CONTENT_TYPE_JSON = 'application/json';
    public const string MARKETPLACE_ID_EBAY_AU = 'EBAY_AU';
    public const string MARKETPLACE_ID_EBAY_CA = 'EBAY_CA';
    public const string MARKETPLACE_ID_EBAY_DE = 'EBAY_DE';
    public const string MARKETPLACE_ID_EBAY_ES = 'EBAY_ES';
    public const string MARKETPLACE_ID_EBAY_FR = 'EBAY_FR';
    public const string MARKETPLACE_ID_EBAY_GB = 'EBAY_GB';
    public const string MARKETPLACE_ID_EBAY_IE = 'EBAY_IE';
    public const string MARKETPLACE_ID_EBAY_IT = 'EBAY_IT';
    public const string MARKETPLACE_ID_EBAY_US = 'EBAY_US';

    /**
     * Builds the headers every Sell Fulfillment API request needs: a freshly
     * resolved OAuth2 bearer token as `Authorization`, the seller's marketplace
     * as `X-EBAY-C-MARKETPLACE-ID`, and the JSON content negotiation headers.
     *
     * @throws BadResponsePayloadFieldExceptionInterface
     * @throws InvalidGrantExceptionInterface
     * @throws RequestExceptionInterface
     *
     * @return array<string, string>
     */
    public function toHeaders(): array;
}
