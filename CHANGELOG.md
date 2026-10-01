# Changelog

All notable changes to this package are recorded here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the package uses
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [3.0.1] - 2026-10-01

### Changed

- The archive Composer installs no longer contains the tests, CI and editor configuration, `CLAUDE.md` or other development-only files, only the library itself, its README, CHANGELOG and LICENSE.

## [3.0.0] - 2026-10-01

A major version because `Http\MultipartFormDataBuilder` is removed and `PaymentDisputeEvidenceApi` takes fewer constructor arguments. Code that builds the client with `SellFulfillmentFactory` needs no changes.

### Changed

- `uploadEvidenceFile` sends its file through api-client's `postMultipart` instead of a body built by hand. The request on the wire is the same: one `file` part with its filename and content type.

### Removed

- `Http\MultipartFormDataBuilder` and its interface, replaced by api-client's multipart support. `PaymentDisputeEvidenceApi` no longer takes it, or a `JsonToArrayTransformerInterface`, as constructor arguments.

## [2.0.0] - 2026-10-01

### Added

- `SellFulfillmentFactory` (and `SellFulfillmentFactoryInterface`) builds a client: `create()` for eBay's production hosts, `createForHost()` for a custom `ApiHostInterface` such as the sandbox.
- `ApplicationCredentials` (and `ApplicationCredentialsInterface`) groups the App ID, Cert ID and marketplace id.

### Changed

- Consumers now get christianjbrown/api-client 3, oauth2-client 2.1 and key-value-store 3. The package requires those majors only, plus `psr/clock` and `symfony/clock`. Key-value stores such as `MemoryKeyValueStore` take a PSR-20 clock in their constructors.
- The lock is required. `SellFulfillmentFactory::create()` and `createForHost()` take a `LockInterface` that is no longer nullable; pass oauth2-client's `NullLock` when you have none. The factory wires a PSR-20 `NativeClock` into the refresh token manager.
- `CoreServiceRegistrar` takes an `ApiClientInterface`, a `RefreshTokenManagerFactoryInterface` and a required `LockInterface`, in addition to the credentials, stores and host.
- `SellFulfillment` now takes a single PSR-11 `ContainerInterface` and builds nothing itself. Replace `new SellFulfillment($appId, $certId, $marketplaceId, $accessStore, $refreshStore, $lock, $apiHost)` with `SellFulfillmentFactory::create()` or `createForHost()`. See "Upgrading to 2.0" in the README.
- `CoreServiceRegistrar` takes an `ApplicationCredentialsInterface` in place of the three credential strings.
- The order services are registered by several smaller registrars (`OrderPricingTransformerRegistrar`, `OrderBuyerTransformerRegistrar`, `OrderCancelTransformerRegistrar`, `OrderFulfillmentInstructionTransformerRegistrar`, `OrderLineItemTransformerRegistrar`, `OrderPaymentTransformerRegistrar`, `OrderProgramTransformerRegistrar`, `OrderResultTransformerRegistrar`, `OrderSerializerRegistrar`, `OrderApiRegistrar`) so a new service group is a new registrar.

### Removed

- `SellFulfillmentInterface::SERVICE_ACCESS_TOKEN_TRANSFORMER`, which nothing uses now that oauth2-client builds its own transformer. `SERVICE_CLIENT_AUTHENTICATION` is added for the client secret authentication service.
- `OrderServiceRegistrar`, replaced by the registrars above.

## [1.1.1] - 2026-09-30

### Changed

- Allows christianjbrown/key-value-store 2.0 as well as 1.x. Nothing this package uses from it changed.

## [1.1.0] - 2026-09-28

Brings the SDK up to date with eBay's `sell_fulfillment` v1.20.6. All additions are optional, so existing
calls keep working.

### Added

- `LineItem` carries `compatibilityProperties`.
- eBay-collected charges are exposed through `EbayCollectedCharges::charges`.
- Fulfillment start instructions carry `appointment` and `destinationTimeZone`, and line item fulfillment
  instructions carry `destinationTimeZone` and `sourceTimeZone`.
- `InfoFromBuyer` carries `contentOnHold`.
- `PaymentDisputeOutcomeDetail` carries `donationCreditAmount`.
- All 40 of eBay's marketplace ids are available as constants on `CredentialsInterface`, up from 9.

## [1.0.0] - 2026-09-28

First stable release.

### Added

- `SellFulfillment`, an entry point for the eBay Sell Fulfillment API. It returns typed model objects and
  takes typed request objects for writes.
- Orders: search and fetch orders, and issue a refund. `getOrders` returns about two years of history, and
  each `LineItem` carries its `legacyItemId`, `lineItemId`, `sku`, `quantity`, `title` and `lineItemCost`.
- Shipping fulfillments: list, fetch and create.
- Payment disputes: fetch, summarise, read activity history, accept and contest, plus adding, updating,
  fetching and uploading evidence.
- OAuth2 user-token authentication using a refresh token, with the access token cached in a
  `TtlAwareKeyValueStoreInterface` and the rotating refresh token kept in a `KeyValueStoreInterface`.
- An optional `LockInterface` argument, so a refresh is serialised across processes and a rotating refresh
  token is never spent twice.
- An optional `ApiHostInterface` argument to target the sandbox or another host.
- A single exception hierarchy, so callers do not depend on the underlying HTTP client.

Only `getOrders` had been exercised against live eBay traffic at this release. The other operations follow
eBay's published contract.

[Unreleased]: https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/compare/v3.0.1...HEAD
[3.0.1]: https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/compare/v3.0.0...v3.0.1
[3.0.0]: https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/compare/v2.0.0...v3.0.0
[2.0.0]: https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/compare/v1.1.1...v2.0.0
[1.1.1]: https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/releases/tag/v1.0.0
