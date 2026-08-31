<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Auth;

use ChristianBrown\EBay\SellFulfillment\Auth\Credentials;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\OAuth2Client\Model\AccessTokenInterface;
use ChristianBrown\OAuth2Client\RefreshTokenManagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Credentials::class)]
final class CredentialsTest extends TestCase
{
    public function testToHeaders(): void
    {
        $clientId = 'test-app-id';

        $accessToken = self::createStub(AccessTokenInterface::class);
        $accessToken->method('getAccessToken')->willReturn('test-access-token');

        $refreshTokenManager = self::createMock(RefreshTokenManagerInterface::class);
        $refreshTokenManager->expects(self::once())->method('getAccessToken')
            ->with($clientId)
            ->willReturn($accessToken);

        $credentials = new Credentials($refreshTokenManager, $clientId, CredentialsInterface::MARKETPLACE_ID_EBAY_GB);

        $expected = [
            CredentialsInterface::HEADER_KEY_ACCEPT => CredentialsInterface::HEADER_VALUE_CONTENT_TYPE_JSON,
            CredentialsInterface::HEADER_KEY_AUTHORIZATION => sprintf(CredentialsInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-access-token'),
            CredentialsInterface::HEADER_KEY_CONTENT_TYPE => CredentialsInterface::HEADER_VALUE_CONTENT_TYPE_JSON,
            CredentialsInterface::HEADER_KEY_MARKETPLACE_ID => CredentialsInterface::MARKETPLACE_ID_EBAY_GB,
        ];

        self::assertSame($expected, $credentials->toHeaders());
    }
}
