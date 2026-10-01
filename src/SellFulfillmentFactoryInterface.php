<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\EBay\SellFulfillment\Auth\ApplicationCredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\Lock\LockInterface;

interface SellFulfillmentFactoryInterface
{
    /**
     * Builds a client that talks to eBay's production hosts.
     */
    public function create(ApplicationCredentialsInterface $credentials, TtlAwareKeyValueStoreInterface $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, LockInterface $lock): SellFulfillmentInterface;

    /**
     * Builds a client that talks to the hosts the given {@see ApiHostInterface} names, for example eBay's sandbox.
     */
    public function createForHost(ApplicationCredentialsInterface $credentials, TtlAwareKeyValueStoreInterface $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, LockInterface $lock, ApiHostInterface $apiHost): SellFulfillmentInterface;
}
