<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Auth;

final class ApplicationCredentials implements ApplicationCredentialsInterface
{
    private string $clientId;
    private string $clientSecret;
    private string $marketplaceId;

    public function __construct(string $clientId, string $clientSecret, string $marketplaceId)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->marketplaceId = $marketplaceId;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getMarketplaceId(): string
    {
        return $this->marketplaceId;
    }
}
