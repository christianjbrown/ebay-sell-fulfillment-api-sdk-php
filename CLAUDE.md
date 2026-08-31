# CLAUDE.md

Guidance for working in this repository. Match the existing conventions exactly — this codebase is
large but completely uniform and highly opinionated, so new code should be indistinguishable from
what's here and from its sibling libraries (`etsy-open-api-sdk`, `smartthings-api-sdk`,
`met-office-weather-datahub-api-sdk`).

## What this is

A strongly-typed PHP 8.5+ client for the [eBay Sell Fulfillment API](https://developer.ebay.com/api-docs/sell/fulfillment/overview.html),
built against eBay's published OpenAPI contract (`sell_fulfillment` **v1.20.0**). It wraps every
method of the API — the `order`, `shipping_fulfillment`, `payment_dispute` and
`payment_dispute_summary` resources — returning typed model objects instead of raw arrays. The
primary entry point is the `SellFulfillment` facade (`src/SellFulfillment.php`), which wires the
resource clients, their transformer and serializer chains, and the OAuth token-refresh machinery
through a Symfony `ContainerBuilder` DI container.

The consumer that motivated it is underpinned.org's lifetime sold count per pin badge. The Browse API
404s on ended listings and the Trading API only reaches 90 days past a listing's end, but `getOrders`
returns roughly **two years** of orders regardless of listing state — so aggregating
`lineItems[].quantity` by `lineItems[].legacyItemId` reconstructs sold counts for ended listings.
`LineItem` must therefore always expose `legacyItemId`, `lineItemId`, `sku`, `quantity`, `title` and
`lineItemCost`; do not drop or rename those.

> **The SDK is unverified against live eBay traffic.** It was written entirely to the documented
> contract because minting the first refresh token needs a browser consent flow. The README's
> "Unverified against live traffic" section lists, in priority order, the calls to smoke-test once a
> token exists (`getOrders` filter syntax and paging first, then `fieldGroups=TAX_BREAKDOWN`,
> `createShippingFulfillment`'s empty `201`, `uploadEvidenceFile`'s multipart body, and
> `fetchEvidenceContent`'s binary body). Update that section as each is confirmed.

## Commands

Binaries install into `bin/` (Composer `bin-dir`), not `vendor/bin/`. Both `bin/` and `vendor/` are
gitignored and Composer-installed, so run `composer install` first.

| Task | Command |
| --- | --- |
| Run tests + coverage (opens HTML report) | `composer test` |
| Run tests, no coverage | `php -d memory_limit=-1 ./bin/phpunit --no-coverage` |
| Run tests + coverage, no browser | `XDEBUG_MODE=coverage php -d memory_limit=-1 ./bin/phpunit` |
| Run one test | `php -d memory_limit=-1 ./bin/phpunit --filter OrderTransformerTest` |
| Static analysis | `composer stan` |
| Check code style | `composer check-style` |
| Auto-fix code style | `composer fix-style` |

After adding autoloadable files, run `composer dump-autoload` if the class isn't found.

Style tooling comes from the `christianjbrown/code-quality-scripts` dev dependency: `check-style`
lints with **PHP_CodeSniffer 4** using the **`ChristianBrown` standard**, and **php-cs-fixer**
(`@PhpCsFixer`/`@Symfony`, risky ruleset) handles formatting. Static analysis is **PHPStan at
`level: max`** (`phpstan.neon.dist`). The **GitHub Actions CI workflow** (`.github/workflows/ci.yml`)
runs style, PHPStan and the PHPUnit suite with coverage on every push/PR; every runtime dependency is
public, so there is deliberately **no `COMPOSER_AUTH` step**. Always run `composer fix-style` first,
then `composer check-style`, then `composer stan`, then `composer test` before finishing.

## Architecture

Layers under `src/`, mirrored 1:1 under `tests/`, plus the top-level `SellFulfillment` facade. PSR-4:
`ChristianBrown\EBay\SellFulfillment\` → `src/`, `ChristianBrown\EBay\SellFulfillment\Tests\` →
`tests/`. Note the StudlyCase `EBay`.

- **`SellFulfillment`** (`src/SellFulfillment.php`) — the facade. Constructed with
  `(string $clientId, string $clientSecret, string $marketplaceId, TtlAwareKeyValueStoreInterface
  $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, ?LockInterface $lock = null)`, it
  builds a `ContainerBuilder`, registers the core services, then the transformer chains, the
  serializer chains, and the API clients last (registration order matters — a service must be
  registered before another wires a `Reference`/`Definition` to it). Service ids are `SERVICE_*`
  constants on `SellFulfillmentInterface`. Getters are PHPStan-safe: assign
  `$this->container->get(...)` to a local `$service` with a `/** @var XApiInterface $service */`
  docblock, then return it.
- **`Auth/`** — `Credentials`, a value object over the OAuth `RefreshTokenManager`. `toHeaders()`
  returns the four headers every request needs: `Authorization: Bearer <token>`,
  `X-EBAY-C-MARKETPLACE-ID`, `Content-Type: application/json` and `Accept: application/json`.
  eBay's token endpoint (`SellFulfillmentInterface::OAUTH_TOKEN_URL`) authenticates with HTTP Basic
  (App ID + Cert ID) and **rotates the refresh token on every refresh**, so the refresh token lives
  in a persistent `KeyValueStoreInterface` and the access token in a
  `TtlAwareKeyValueStoreInterface`; the optional `LockInterface` serialises concurrent refreshes.
- **`Api/`** — one `final` client per resource group (`OrderApi`, `ShippingFulfillmentApi`,
  `PaymentDisputeApi`, `PaymentDisputeEvidenceApi`), each implementing its interface which
  `extends ApiInterface`. Full URLs live in `API_URL*` constants on the interface. **Order and
  fulfillment calls go to `https://api.ebay.com`; every payment-dispute call goes to
  `https://apiz.ebay.com`** — that split is real, not a typo. Constructor order: the request
  sender(s), then the transformers, then the serializers, then the `CredentialsInterface`. `GET`
  methods use `JsonApiRequestSenderInterface` and cache by a derived key with a `bool $skipCache`
  escape hatch. Endpoints that answer `204`/`201` with an **empty body** (`createShippingFulfillment`,
  `acceptPaymentDispute`, `contestPaymentDispute`, `updateEvidence`) or with **non-JSON bytes**
  (`fetchEvidenceContent`) use the raw `ApiRequestSenderInterface` instead, encoding the request body
  through api-client's `ArrayToJsonTransformerInterface`, because the JSON sender cannot decode an
  empty body.
- **`Model/`** — plain, mutable typed DTOs with getters and fluent setters; one per schema in the
  contract. Two schemas are singularised because they name a single object: eBay's `OrderLineItems`
  is `OrderLineItem` and `SellerActionsToRelease` is `SellerActionToRelease` (their collection
  transformers then take the original plural names).
- **`Transformer/`** — turn raw decoded-JSON arrays into `Model` objects. Nested transformers are
  constructor-injected and composed into a chain. Plural transformers wrap the singular one for
  arrays; the shared `StringsTransformer` handles arrays of plain strings
  (`Order::fulfillmentHrefs`, `PaymentDispute::availableChoices`, `Error::inputRefIds`).
- **`Serializer/`** — the mirror image, turning request `Model` objects into the arrays eBay expects.
  One `serialize(XInterface $x): array` per request schema, plus plural serializers for arrays.
- **`Filter/`** — `OrderFilter` renders `getOrders`' `filter` query-string value
  (`creationdate:[from..to]`, `lastmodifieddate:[..to]`, `orderfulfillmentstatus:{A|B}`), converting
  the supplied `DateTimeInterface` bounds to UTC. `MAX_HISTORY_YEARS` records eBay's two-year window.
- **`Http/`** — `MultipartFormDataBuilder`, used only by `uploadEvidenceFile`, which is the one
  request eBay wants as `multipart/form-data` rather than JSON (field name must be `file`).
- **`Exception/`** — `final` exception classes + matching interfaces, each extending the library-wide
  `ExceptionInterface` (which extends `Throwable`): `UnexpectedResponseException` (extends
  `RuntimeException`) and `MissingInputException` (extends `InvalidArgumentException`).

## Conventions (follow all of these)

- `declare(strict_types=1);` on every file, immediately after `<?php`.
- **Every concrete class is `final` and implements a matching `...Interface`** in the same namespace.
  No abstract base classes — composition over inheritance.
- **Constants live on the interface, not the class**: URLs (`API_URL*`), JSON keys (`KEY_*`), service
  ids (`SERVICE_*`), collection names (`ARRAY_NAME`), and sprintf message templates (`*_SPRINTF`).
  Typed constants (`public const string KEY_… = '…';`). No string literal message text in a class body.
- **No constructor property promotion** — declare typed `private` properties and assign them in the
  constructor body. Class members (properties then methods) are ordered **alphabetically**;
  `composer fix-style` enforces it.
- Import functions with `use function is_array;` etc. (after class imports, blank line between), and
  call them unqualified.
- **Models**: every field in this contract is optional, so properties default to `null` (or `[]` for
  arrays) and there are no constructor arguments. Getters `getX()`; fluent setters `setX($value)`
  (param literally `$value`) that `return $this` typed as the **interface**. No enums, no `readonly`,
  no immutability.
- **Transformers**: one `transform(array $data): ...` method delegating to one `applyX` helper per
  field. Guard required fields with a presence check then a type check (each its own `if`, never a
  compound `&&`/`||`), throwing `UnexpectedResponseException`. Use `empty()` for the presence check on
  **string/array** fields, but **`isset()` for numeric and boolean fields** so a legitimate `0`/`false`
  isn't dropped. Optional fields are **silently skipped** when absent or wrong-typed. Collection
  transformers loop with an indexed `for` over `array_values($data)` and throw
  `UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME))` on a
  non-array element.
- **Serializers**: one `serialize(XInterface $x): array` delegating to one `applyX(array $data, ...):
  array` helper per field, each returning the (possibly unchanged) array — no reference parameters.
  A `null` (or empty-array) value is omitted from the payload entirely.
- **Avoid `foreach` and compound `&&`/`||` in `src/`** — use indexed `for` loops and sequential `if`
  guards. Several sequential `if`s inside one method multiply into a cartesian product of xdebug
  paths, so split optional-argument handling into one small helper per argument instead.
- **A method that does not use `$this` must be `static`** (called via `self::`) — enforced for private
  methods by the shared `RequireStaticPrivateMethodRule` PHPStan rule.
- Public methods that can throw carry `@throws` docblocks naming the concrete exception interfaces.
  Array shapes are documented with `@param mixed[]` / `@return array<int, XInterface>` docblocks. If a
  method documents any `@param`, phpcs requires them in declaration order starting from the first
  parameter — describe the rest in prose rather than documenting a middle parameter alone.

## Testing

The `phpunit.xml` config is strict (`requireCoverageMetadata`, `beStrictAboutCoverageMetadata`,
`failOnRisky`, `failOnWarning`, path coverage; `<source>` keeps `restrictNotices`/`restrictWarnings`
on but `ignoreIndirectDeprecations` so Symfony DI's deprecations don't fail the suite).

- **Coverage must stay at 100%** — line, path, method/function, branch and class. Every defensive
  guard and every optional-field branch must be exercised.
- **The compound-condition and cartesian traps**: keep one condition per `if`. For wide models, do
  NOT test a cartesian product of fields — path coverage is per-method and each `applyX` is
  independent, so cover it linearly: one "all fields valid" case, then per field one "absent" and one
  "wrong-type" case (plus a `0`/`false` case for numeric and boolean fields, to prove `isset()` and
  not `empty()` is used).
- **Every test class needs a `#[CoversClass(...)]` attribute**, and may list more than one — a
  transformer test covers both the transformer and the model it builds, and a serializer test covers
  both the serializer and the model it reads (serializer tests therefore construct the **real** model,
  not a stub, and stub only the nested serializers).
- Tests mirror `src/` 1:1 under `tests/<Layer>/`, one `final class XTest extends TestCase` per class.
  Use `self::createStub(...)` for pure return-value doubles and `self::createMock(...)` with
  `expects()` where a call must be verified; assert statically (`self::assertSame`). Reference the
  **same interface constants** production code uses — for both data keys and expected exception
  messages — so no strings are hardcoded. Use PHPUnit **attributes, not annotations**
  (`#[CoversClass]`, `#[DataProvider]`), and name providers `provide<TestName>Cases`.

## Adding a feature (a new resource / endpoint)

eBay's contract is the source of truth. The published OpenAPI document is
`https://developer.ebay.com/api-docs/master/sell/fulfillment/openapi/3/sell_fulfillment_v1_oas3.json`
(it 403s to plain `curl`; a mirror lives at
`https://raw.githubusercontent.com/APIs-guru/openapi-directory/main/APIs/ebay.com/sell-fulfillment/v1.20.0/openapi.yaml`).
Diff it against `src/` before adding anything, and copy field names from it verbatim — a wrong key
fails silently at runtime.

1. Add the `Model` DTO(s) + interface(s), one property per schema property.
2. Add the `Transformer`(s) + interfaces with `KEY_*` constants on the interface (and the
   `ARRAY_NAME`/`UNEXPECTED_ARRAY_SPRINTF` pair on any new collection transformer). For a request
   schema, add the mirroring `Serializer` instead (or as well, for a schema used both ways).
3. Add or extend the `Api` client + interface (`API_URL*` constants, `extends ApiInterface`),
   remembering the `api.ebay.com` / `apiz.ebay.com` host split and whether the response has a body.
4. Register the new chain and client in `SellFulfillment`'s `register*` methods with new `SERVICE_*`
   ids on `SellFulfillmentInterface`, in dependency order, and add any new `getXApi()` getter.
5. Add matching `#[CoversClass]` tests under `tests/<Layer>/`, plus the endpoint to the README table.
6. Run `composer fix-style`, then `composer check-style`, `composer stan`, and `composer test`, and
   **confirm the coverage report is 100%** on lines, paths, methods, branches and classes.
