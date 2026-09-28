<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Http;

use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiHost::class)]
final class ApiHostTest extends TestCase
{
    public function testDefaultsToProduction(): void
    {
        $apiHost = new ApiHost();

        self::assertSame(ApiHostInterface::DEFAULT_API_URL, $apiHost->getApiUrl());
        self::assertSame(ApiHostInterface::DEFAULT_APIZ_URL, $apiHost->getApizUrl());
        self::assertSame(ApiHostInterface::DEFAULT_OAUTH_TOKEN_URL, $apiHost->getOAuthTokenUrl());
    }

    public function testOverridesEveryHost(): void
    {
        $apiHost = new ApiHost('https://api.sandbox.ebay.com', 'https://apiz.sandbox.ebay.com', 'https://api.sandbox.ebay.com/identity/v1/oauth2/token');

        self::assertSame('https://api.sandbox.ebay.com', $apiHost->getApiUrl());
        self::assertSame('https://apiz.sandbox.ebay.com', $apiHost->getApizUrl());
        self::assertSame('https://api.sandbox.ebay.com/identity/v1/oauth2/token', $apiHost->getOAuthTokenUrl());
    }
}
