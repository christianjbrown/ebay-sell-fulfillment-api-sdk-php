<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Http;

final class ApiHost implements ApiHostInterface
{
    private string $apiUrl;
    private string $apizUrl;
    private string $oAuthTokenUrl;

    public function __construct(string $apiUrl = self::DEFAULT_API_URL, string $apizUrl = self::DEFAULT_APIZ_URL, string $oAuthTokenUrl = self::DEFAULT_OAUTH_TOKEN_URL)
    {
        $this->apiUrl = $apiUrl;
        $this->apizUrl = $apizUrl;
        $this->oAuthTokenUrl = $oAuthTokenUrl;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getApizUrl(): string
    {
        return $this->apizUrl;
    }

    public function getOAuthTokenUrl(): string
    {
        return $this->oAuthTokenUrl;
    }
}
