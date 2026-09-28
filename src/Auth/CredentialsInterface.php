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
    public const string MARKETPLACE_ID_EBAY_AT = 'EBAY_AT';
    public const string MARKETPLACE_ID_EBAY_AU = 'EBAY_AU';
    public const string MARKETPLACE_ID_EBAY_BE = 'EBAY_BE';
    public const string MARKETPLACE_ID_EBAY_CA = 'EBAY_CA';
    public const string MARKETPLACE_ID_EBAY_CH = 'EBAY_CH';
    public const string MARKETPLACE_ID_EBAY_CN = 'EBAY_CN';
    public const string MARKETPLACE_ID_EBAY_CZ = 'EBAY_CZ';
    public const string MARKETPLACE_ID_EBAY_DE = 'EBAY_DE';
    public const string MARKETPLACE_ID_EBAY_DK = 'EBAY_DK';
    public const string MARKETPLACE_ID_EBAY_ES = 'EBAY_ES';
    public const string MARKETPLACE_ID_EBAY_FI = 'EBAY_FI';
    public const string MARKETPLACE_ID_EBAY_FR = 'EBAY_FR';
    public const string MARKETPLACE_ID_EBAY_GB = 'EBAY_GB';
    public const string MARKETPLACE_ID_EBAY_GR = 'EBAY_GR';
    public const string MARKETPLACE_ID_EBAY_HALF_US = 'EBAY_HALF_US';
    public const string MARKETPLACE_ID_EBAY_HK = 'EBAY_HK';
    public const string MARKETPLACE_ID_EBAY_HU = 'EBAY_HU';
    public const string MARKETPLACE_ID_EBAY_ID = 'EBAY_ID';
    public const string MARKETPLACE_ID_EBAY_IE = 'EBAY_IE';
    public const string MARKETPLACE_ID_EBAY_IL = 'EBAY_IL';
    public const string MARKETPLACE_ID_EBAY_IN = 'EBAY_IN';
    public const string MARKETPLACE_ID_EBAY_IT = 'EBAY_IT';
    public const string MARKETPLACE_ID_EBAY_JP = 'EBAY_JP';
    public const string MARKETPLACE_ID_EBAY_MOTORS_US = 'EBAY_MOTORS_US';
    public const string MARKETPLACE_ID_EBAY_MY = 'EBAY_MY';
    public const string MARKETPLACE_ID_EBAY_NL = 'EBAY_NL';
    public const string MARKETPLACE_ID_EBAY_NO = 'EBAY_NO';
    public const string MARKETPLACE_ID_EBAY_NZ = 'EBAY_NZ';
    public const string MARKETPLACE_ID_EBAY_PE = 'EBAY_PE';
    public const string MARKETPLACE_ID_EBAY_PH = 'EBAY_PH';
    public const string MARKETPLACE_ID_EBAY_PL = 'EBAY_PL';
    public const string MARKETPLACE_ID_EBAY_PR = 'EBAY_PR';
    public const string MARKETPLACE_ID_EBAY_PT = 'EBAY_PT';
    public const string MARKETPLACE_ID_EBAY_RU = 'EBAY_RU';
    public const string MARKETPLACE_ID_EBAY_SE = 'EBAY_SE';
    public const string MARKETPLACE_ID_EBAY_SG = 'EBAY_SG';
    public const string MARKETPLACE_ID_EBAY_TH = 'EBAY_TH';
    public const string MARKETPLACE_ID_EBAY_TW = 'EBAY_TW';
    public const string MARKETPLACE_ID_EBAY_US = 'EBAY_US';
    public const string MARKETPLACE_ID_EBAY_VN = 'EBAY_VN';
    public const string MARKETPLACE_ID_EBAY_ZA = 'EBAY_ZA';

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
