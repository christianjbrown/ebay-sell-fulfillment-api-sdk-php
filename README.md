# eBay Sell Fulfillment API SDK

[![CI](https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/actions/workflows/ci.yml) [![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen)](https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/actions/workflows/ci.yml) [![Packagist](https://img.shields.io/packagist/v/christianjbrown/ebay-sell-fulfillment-api-sdk)](https://packagist.org/packages/christianjbrown/ebay-sell-fulfillment-api-sdk) [![License](https://img.shields.io/packagist/l/christianjbrown/ebay-sell-fulfillment-api-sdk)](https://github.com/christianjbrown/ebay-sell-fulfillment-api-sdk-php/blob/main/LICENSE) [![PHP](https://img.shields.io/packagist/dependency-v/christianjbrown/ebay-sell-fulfillment-api-sdk/php)](https://packagist.org/packages/christianjbrown/ebay-sell-fulfillment-api-sdk)

A strongly-typed PHP client for the [eBay Sell Fulfillment API](https://developer.ebay.com/api-docs/sell/fulfillment/overview.html). It reads a seller's orders, shipments and payment disputes — and writes shipping fulfillments, refunds and dispute responses — returning plain, typed model objects rather than raw arrays.

`getOrders` returns roughly **two years** of order history, which makes it the practical way to reconstruct lifetime sold counts per listing: every `LineItem` carries its `legacyItemId`, `lineItemId`, `sku`, `quantity`, `title` and `lineItemCost`, so aggregating `quantity` by `legacyItemId` gives a sold count that survives the listing ending.

> :warning: **Only `getOrders` has been exercised against live eBay traffic.** The rest is built strictly to eBay's published OpenAPI contract (`sell_fulfillment` v1.20.6). See [Live traffic](#live-traffic) for what has been confirmed and what to smoke-test next.

### Supported endpoints

| Resource | Client | Endpoint(s) | Returns |
| --- | --- | --- | --- |
| Orders | `getOrderApi()` | `GET /order`, `GET /order/{orderId}`, `POST /order/{orderId}/issue_refund` | `OrderSearchPagedCollectionInterface` / `OrderInterface` / `RefundInterface` |
| Shipping fulfillments | `getShippingFulfillmentApi()` | `GET /order/{orderId}/shipping_fulfillment`, `GET /order/{orderId}/shipping_fulfillment/{fulfillmentId}`, `POST /order/{orderId}/shipping_fulfillment` | `ShippingFulfillmentPagedCollectionInterface` / `ShippingFulfillmentInterface` / `void` |
| Payment disputes | `getPaymentDisputeApi()` | `GET /payment_dispute/{payment_dispute_id}`, `GET /payment_dispute_summary`, `GET /payment_dispute/{payment_dispute_id}/activity`, `POST /payment_dispute/{payment_dispute_id}/accept`, `POST /payment_dispute/{payment_dispute_id}/contest` | `PaymentDisputeInterface` / `DisputeSummaryResponseInterface` / `PaymentDisputeActivityHistoryInterface` / `void` |
| Payment dispute evidence | `getPaymentDisputeEvidenceApi()` | `POST /payment_dispute/{payment_dispute_id}/add_evidence`, `POST /payment_dispute/{payment_dispute_id}/update_evidence`, `GET /payment_dispute/{payment_dispute_id}/fetch_evidence_content`, `POST /payment_dispute/{payment_dispute_id}/upload_evidence_file` | `AddEvidencePaymentDisputeResponseInterface` / `void` / `string` / `FileEvidenceInterface` |

Every response type in the contract is modelled: `Order`, `LineItem`, `LineItemFulfillmentInstructions`, `Buyer`, `PricingSummary`, `PaymentSummary`, `Payment`, `FulfillmentStartInstruction`, `ShippingStep`, `Address`, `Amount`, `Tax`, `Refund`, `ShippingFulfillment`, `PaymentDispute`, `DisputeEvidence` and the rest, plus eBay's standard `Error` payload (returned in the `warnings` array of both paged collections).

## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.

## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/ebay-sell-fulfillment-api-sdk
```

## :computer: Usage

Every Sell Fulfillment request carries an **OAuth 2.0 user access token** (`Authorization: Bearer …`) and the seller's marketplace (`X-EBAY-C-MARKETPLACE-ID`). Access tokens are short-lived, so this client refreshes them for you using a long-lived **refresh token** and the OAuth2 `refresh_token` grant against `https://api.ebay.com/identity/v1/oauth2/token`.

You need a user token minted for the `https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly` scope (or `…/sell.fulfillment` for the write endpoints). Both are on `SellFulfillmentInterface` as `OAUTH_SCOPE_SELL_FULFILLMENT_READONLY` and `OAUTH_SCOPE_SELL_FULFILLMENT`. Obtaining the first refresh token needs a one-off browser consent flow, described in eBay's [Getting user consent](https://developer.ebay.com/api-docs/static/oauth-consent-request.html) guide.

You supply five things to the `SellFulfillment` entry point:

- your **App ID** (client id),
- your **Cert ID** (client secret — eBay's token endpoint authenticates with HTTP Basic),
- the **marketplace id** (`EBAY_GB`, `EBAY_US`, … — constants on `CredentialsInterface`),
- a **`TtlAwareKeyValueStoreInterface`** to hold the current access token (an in-memory store is fine — it's re-fetched as needed),
- a **`KeyValueStoreInterface`** holding your refresh token. This one must **persist**, because eBay rotates the refresh token on every refresh and the client writes the new value back.

An optional sixth argument, a `LockInterface`, serialises the refresh across processes so a rotating refresh token is never spent by two refreshes at once. An optional seventh argument, an `ApiHostInterface`, overrides the hosts every request is built from — see [Targeting the sandbox](#targeting-the-sandbox) below.

```php
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\SellFulfillment;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;

// Access token: transient, an in-memory (TTL-aware) store is fine.
$accessTokenStore = new MemoryKeyValueStore();

// Refresh token: must persist and already hold a valid refresh token.
// Any KeyValueStoreInterface works (DatabaseKeyValueStore, GoogleSecretKeyValueStore, …).
$refreshTokenStore = new MemoryKeyValueStore();
$refreshTokenStore->setValue('your-seed-refresh-token');

$sellFulfillment = new SellFulfillment(
    'your-app-id',
    'your-cert-id',
    CredentialsInterface::MARKETPLACE_ID_EBAY_GB,
    $accessTokenStore,
    $refreshTokenStore
);

$orderApi = $sellFulfillment->getOrderApi();   // OrderApiInterface
```

### Targeting the sandbox

Every request is built from a host the client resolves through `ApiHostInterface`: `getApiUrl()` for order and shipping fulfillment calls (defaults to `https://api.ebay.com`), `getApizUrl()` for payment dispute calls (defaults to `https://apiz.ebay.com`), and `getOAuthTokenUrl()` for the token endpoint (defaults to `https://api.ebay.com/identity/v1/oauth2/token`). Pass a custom `ApiHost` as the seventh constructor argument to point the whole client at eBay's sandbox — `https://api.sandbox.ebay.com` and `https://apiz.sandbox.ebay.com`:

```php
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;

$sandboxHost = new ApiHost(
    'https://api.sandbox.ebay.com',
    'https://apiz.sandbox.ebay.com',
    'https://api.sandbox.ebay.com/identity/v1/oauth2/token'
);

$sellFulfillment = new SellFulfillment(
    'your-sandbox-app-id',
    'your-sandbox-cert-id',
    CredentialsInterface::MARKETPLACE_ID_EBAY_GB,
    $accessTokenStore,
    $refreshTokenStore,
    null,
    $sandboxHost
);
```

### Reading orders

`getOrders` is paginated. The returned collection exposes `getTotal()`, `getLimit()`, `getOffset()`, `getNext()` and `getPrev()`, so driving the pages is a plain loop on `offset`:

```php
use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Filter\OrderFilter;

// eBay retains roughly two years of order history; a lower bound earlier than
// OrderFilterInterface::MAX_HISTORY_YEARS ago returns nothing extra.
$filter = (new OrderFilter())
    ->setCreationDateFrom(new DateTimeImmutable('-2 years'));

$soldByLegacyItemId = [];
$offset = 0;

do {
    $page = $orderApi->getOrders($filter->toFilterString(), null, null, OrderApiInterface::MAX_LIMIT, $offset);

    foreach ($page->getOrders() as $order) {
        foreach ($order->getLineItems() as $lineItem) {
            $legacyItemId = $lineItem->getLegacyItemId();
            if ($legacyItemId === null) {
                continue;
            }

            $soldByLegacyItemId[$legacyItemId] ??= 0;
            $soldByLegacyItemId[$legacyItemId] += $lineItem->getQuantity() ?? 0;
        }
    }

    $offset += OrderApiInterface::MAX_LIMIT;
} while ($offset < ($page->getTotal() ?? 0));
```

A single order, optionally with the tax and fee breakdown:

```php
$order = $orderApi->getOrder('03-06614-05610', OrderApiInterface::FIELD_GROUPS_TAX_BREAKDOWN);

printf("%s — %s\n", $order->getOrderId(), $order->getOrderFulfillmentStatus() ?? 'unknown');

$total = $order->getPricingSummary()?->getTotal();
if ($total !== null) {
    printf("  Total: %s %s\n", $total->getValue(), $total->getCurrency());
}
```

### Shipping fulfillments

```php
use ChristianBrown\EBay\SellFulfillment\Model\LineItemReference;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentDetails;

$shippingFulfillmentApi = $sellFulfillment->getShippingFulfillmentApi();

$details = (new ShippingFulfillmentDetails())
    ->setLineItems([(new LineItemReference())->setLineItemId('1234567890')->setQuantity(1)])
    ->setShippingCarrierCode('ROYALMAIL')
    ->setTrackingNumber('AB123456789GB');

// eBay answers 201 with the new id in the Location header and an empty body, so
// nothing is returned; read the fulfillment back to see it.
$shippingFulfillmentApi->createShippingFulfillment('03-06614-05610', $details);

$fulfillments = $shippingFulfillmentApi->getShippingFulfillments('03-06614-05610');
```

### Payment disputes

```php
$paymentDisputeApi = $sellFulfillment->getPaymentDisputeApi();

$summaries = $paymentDisputeApi->getPaymentDisputeSummaries();
foreach ($summaries->getPaymentDisputeSummaries() as $summary) {
    printf("%s — %s\n", $summary->getPaymentDisputeId(), $summary->getPaymentDisputeStatus() ?? 'unknown');
}

$dispute = $paymentDisputeApi->getPaymentDispute('5000005000');
```

Evidence files are uploaded first and then attached to an evidence set:

```php
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeRequest;
use ChristianBrown\EBay\SellFulfillment\Model\FileEvidence;

$evidenceApi = $sellFulfillment->getPaymentDisputeEvidenceApi();

$file = $evidenceApi->uploadEvidenceFile(
    '5000005000',
    'proof-of-delivery.png',
    PaymentDisputeEvidenceApiInterface::CONTENT_TYPE_PNG,
    file_get_contents('proof-of-delivery.png')
);

$request = (new AddEvidencePaymentDisputeRequest())
    ->setEvidenceType('PROOF_OF_DELIVERY')
    ->setFiles([(new FileEvidence())->setFileId($file->getFileId())]);

$evidence = $evidenceApi->addEvidence('5000005000', $request);
```

### Live traffic

**`getOrders`** runs against a real seller account: the `creationdate:[…..…]` filter, `limit`/`offset` paging, and `lineItems[].legacyItemId` and `lineItems[].quantity` all behave as documented, and eBay accepts the `:` and `,` that `http_build_query` percent-encodes. One thing the documentation does not say: a `creationdate` lower bound older than eBay's roughly two-year retention is rejected with errorId `30830` rather than quietly clamped, so keep the window inside it.

Nothing else has been run against a real account yet. Smoke-test in this order, since these are the calls whose contract detail is most likely to bite:

1. **`getOrder`** — the `fieldGroups=TAX_BREAKDOWN` variant.
2. **`createShippingFulfillment`** — that the `201`/empty body is handled and the payload shape is accepted.
3. **`uploadEvidenceFile`** — the hand-built `multipart/form-data` body (field name `file`), which is the only request this SDK does not encode as JSON.
4. **`fetchEvidenceContent`** — that the raw `application/octet-stream` body comes back intact.

Payment dispute calls are served from `apiz.ebay.com`; order and fulfillment calls from `api.ebay.com`. Both hosts are baked into the `API_URL*` constants on the client interfaces.

## :rotating_light: Error handling

Everything this library throws implements `ChristianBrown\EBay\SellFulfillment\Exception\ExceptionInterface`, so a single `catch` covers it all:

```php
use ChristianBrown\EBay\SellFulfillment\Exception\ExceptionInterface;

try {
    $orders = $orderApi->getOrders();
} catch (ExceptionInterface $exception) {
    // Anything this library throws lands here.
}
```

There are two concrete types:

- **`UnexpectedResponseException`** (extends `RuntimeException`) — eBay returned a body the client or a transformer couldn't parse (a missing or mis-typed field, an empty response).
- **`MissingInputException`** (extends `InvalidArgumentException`) — bad caller input.

Both live in `src/Exception/`. Request-level failures (network errors, non-2xx responses) surface as the exception interfaces of [`christianjbrown/api-client`](https://github.com/christianjbrown/api-client-php) — `BadResponseExceptionInterface` exposes eBay's decoded error payload through `getDecodedBody()`. Token-refresh failures surface as `ChristianBrown\OAuth2Client\Model\Exception\ExceptionInterface` from [`christianjbrown/oauth2-client`](https://github.com/christianjbrown/oauth2-client-php); in particular `InvalidGrantExceptionInterface` means the refresh token is dead and the consent flow has to be repeated. None of those are in this library's exception hierarchy.

Under the hood, `SellFulfillment` wires the clients, their transformer and serializer chains, and the OAuth refresh machinery through a [Symfony dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) container. If you don't want the container, you can build the same chains by hand — every class is `final`, takes its collaborators as constructor arguments, and implements a matching interface.

## :memo: Changelog

Notable changes in each release are listed in [CHANGELOG.md](CHANGELOG.md).



## :page_facing_up: License

Released under the [MIT License](LICENSE).
