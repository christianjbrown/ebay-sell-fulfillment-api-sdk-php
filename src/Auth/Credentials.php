<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Auth;

use ChristianBrown\OAuth2Client\Model\Exception\BadResponsePayloadFieldExceptionInterface;
use ChristianBrown\OAuth2Client\Model\Exception\InvalidGrantExceptionInterface;
use ChristianBrown\OAuth2Client\Model\Exception\RequestExceptionInterface;
use ChristianBrown\OAuth2Client\RefreshTokenManagerInterface;

use function sprintf;

final class Credentials implements CredentialsInterface
{
    private string $clientId;
    private string $marketplaceId;
    private RefreshTokenManagerInterface $refreshTokenManager;

    public function __construct(RefreshTokenManagerInterface $refreshTokenManager, string $clientId, string $marketplaceId)
    {
        $this->refreshTokenManager = $refreshTokenManager;
        $this->clientId = $clientId;
        $this->marketplaceId = $marketplaceId;
    }

    /**
     * @throws BadResponsePayloadFieldExceptionInterface
     * @throws InvalidGrantExceptionInterface
     * @throws RequestExceptionInterface
     *
     * @return array<string, string>
     */
    public function toHeaders(): array
    {
        // The App ID doubles as the OAuth2 client_id; the refresh-token manager
        // returns a cached access token or transparently refreshes it, writing
        // eBay's rotated refresh token back to the persistent store.
        $accessToken = $this->refreshTokenManager->getAccessToken($this->clientId);

        return [
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_CONTENT_TYPE_JSON,
            self::HEADER_KEY_AUTHORIZATION => sprintf(self::AUTHORIZATION_HEADER_VALUE_SPRINTF, $accessToken->getAccessToken()),
            self::HEADER_KEY_CONTENT_TYPE => self::HEADER_VALUE_CONTENT_TYPE_JSON,
            self::HEADER_KEY_MARKETPLACE_ID => $this->marketplaceId,
        ];
    }
}
