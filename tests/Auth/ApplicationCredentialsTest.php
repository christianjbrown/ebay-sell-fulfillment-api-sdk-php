<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Auth;

use ChristianBrown\EBay\SellFulfillment\Auth\ApplicationCredentials;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApplicationCredentials::class)]
final class ApplicationCredentialsTest extends TestCase
{
    public function testExposesWhatItWasBuiltWith(): void
    {
        $credentials = new ApplicationCredentials('app-id', 'cert-id', CredentialsInterface::MARKETPLACE_ID_EBAY_GB);

        self::assertSame('app-id', $credentials->getClientId());
        self::assertSame('cert-id', $credentials->getClientSecret());
        self::assertSame(CredentialsInterface::MARKETPLACE_ID_EBAY_GB, $credentials->getMarketplaceId());
    }
}
