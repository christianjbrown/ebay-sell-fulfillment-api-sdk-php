<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformer;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformer;
use ChristianBrown\EBay\SellFulfillment\Api\OrderApi;
use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApi;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApi;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApi;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApiInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\Credentials;
use ChristianBrown\EBay\SellFulfillment\Http\MultipartFormDataBuilder;
use ChristianBrown\EBay\SellFulfillment\Serializer\AcceptPaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\AddEvidencePaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ContestPaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidencesSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\IssueRefundRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LegacyReferenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferencesSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemsSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\PhoneSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemsSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ReturnAddressSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ShippingFulfillmentDetailsSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\SimpleAmountSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\UpdateEvidencePaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddEvidencePaymentDisputeResponseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\BuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelStatusTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DeliveryCostTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeAmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidencesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeSummaryResponseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectedChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayFulfillmentProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayInternationalShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayTaxReferenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayVaultProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ExtendedContactTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileEvidenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfosTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfoTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\GiftDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\InfoFromBuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemFulfillmentInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemPropertiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferencesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemReferenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderSearchPagedCollectionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrdersTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivitiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityHistoryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeOutcomeDetailTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummariesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneNumberTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PickupStepTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PostSaleAuthenticationProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PricingSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\RefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ReturnAddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionsToReleaseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionToReleaseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentPagedCollectionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingFulfillmentTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingStepTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SimpleAmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\StringsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxAddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxIdentifierTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfosTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TrackingInfoTransformer;
use ChristianBrown\KeyValueStore\KeyValueStoreInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\Lock\LockInterface;
use ChristianBrown\OAuth2Client\RefreshTokenManager;
use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SellFulfillment implements SellFulfillmentInterface
{
    private TtlAwareKeyValueStoreInterface $accessTokenStore;
    private string $clientId;
    private string $clientSecret;
    private ContainerBuilder $container;
    private ?LockInterface $lock;
    private string $marketplaceId;
    private KeyValueStoreInterface $refreshTokenStore;

    public function __construct(string $clientId, string $clientSecret, string $marketplaceId, TtlAwareKeyValueStoreInterface $accessTokenStore, KeyValueStoreInterface $refreshTokenStore, ?LockInterface $lock = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->marketplaceId = $marketplaceId;
        $this->accessTokenStore = $accessTokenStore;
        $this->refreshTokenStore = $refreshTokenStore;
        $this->lock = $lock;
        $this->container = new ContainerBuilder();
        $this->init();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getOrderApi(): OrderApiInterface
    {
        /**
         * @var OrderApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ORDER_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPaymentDisputeApi(): PaymentDisputeApiInterface
    {
        /**
         * @var PaymentDisputeApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_PAYMENT_DISPUTE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPaymentDisputeEvidenceApi(): PaymentDisputeEvidenceApiInterface
    {
        /**
         * @var PaymentDisputeEvidenceApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_PAYMENT_DISPUTE_EVIDENCE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getShippingFulfillmentApi(): ShippingFulfillmentApiInterface
    {
        /**
         * @var ShippingFulfillmentApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SHIPPING_FULFILLMENT_API);

        return $service;
    }

    private function init(): void
    {
        // Registration order matters: a service must be registered before another
        // service wires a reference to its definition, so core comes first, then the
        // transformer and serializer chains, and the API clients last.
        $this->registerCore();
        $this->registerSharedTransformers();
        $this->registerOrderTransformers();
        $this->registerShippingFulfillmentTransformers();
        $this->registerPaymentDisputeTransformers();
        $this->registerOrderSerializers();
        $this->registerShippingFulfillmentSerializers();
        $this->registerPaymentDisputeSerializers();
        $this->registerApiClients();
    }

    private function registerApiClients(): void
    {
        $this->container->register(self::SERVICE_ORDER_API, OrderApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_ORDER_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ORDER_SEARCH_PAGED_COLLECTION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_REFUND_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ISSUE_REFUND_REQUEST_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_CREDENTIALS),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_API, PaymentDisputeApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_ARRAY_TO_JSON_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PAYMENT_DISPUTE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PAYMENT_DISPUTE_ACTIVITY_HISTORY_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_DISPUTE_SUMMARY_RESPONSE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ACCEPT_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_CONTEST_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_CREDENTIALS),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_EVIDENCE_API, PaymentDisputeEvidenceApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_ARRAY_TO_JSON_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_JSON_TO_ARRAY_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_MULTIPART_FORM_DATA_BUILDER),
                    $this->container->getDefinition(self::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_RESPONSE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_FILE_EVIDENCE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_UPDATE_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_CREDENTIALS),
                ]
            );

        $this->container->register(self::SERVICE_SHIPPING_FULFILLMENT_API, ShippingFulfillmentApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_ARRAY_TO_JSON_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIPPING_FULFILLMENT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIPPING_FULFILLMENT_PAGED_COLLECTION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIPPING_FULFILLMENT_DETAILS_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_CREDENTIALS),
                ]
            );
    }

    private function registerCore(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_API_REQUEST_SENDER, ApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getApiRequestSender']);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $this->container->register(self::SERVICE_ARRAY_TO_JSON_TRANSFORMER, ArrayToJsonTransformer::class);
        $this->container->register(self::SERVICE_JSON_TO_ARRAY_TRANSFORMER, JsonToArrayTransformer::class);
        $this->container->register(self::SERVICE_MULTIPART_FORM_DATA_BUILDER, MultipartFormDataBuilder::class);

        $this->container->register(self::SERVICE_ACCESS_TOKEN_TRANSFORMER, AccessTokenTransformer::class);

        // eBay's token endpoint authenticates with HTTP Basic (App ID and Cert ID)
        // and rotates the refresh token on every refresh, so the refresh-token
        // store must persist and the optional lock serialises concurrent refreshes.
        $this->container->register(self::SERVICE_REFRESH_TOKEN_MANAGER, RefreshTokenManager::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->accessTokenStore,
                    $this->refreshTokenStore,
                    $this->container->getDefinition(self::SERVICE_ACCESS_TOKEN_TRANSFORMER),
                    self::OAUTH_TOKEN_URL,
                    $this->clientSecret,
                    $this->lock,
                ]
            );

        $this->container->register(self::SERVICE_CREDENTIALS, Credentials::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_REFRESH_TOKEN_MANAGER),
                    $this->clientId,
                    $this->marketplaceId,
                ]
            );
    }

    private function registerOrderSerializers(): void
    {
        $this->container->register(self::SERVICE_LEGACY_REFERENCE_SERIALIZER, LegacyReferenceSerializer::class);

        $this->container->register(self::SERVICE_SIMPLE_AMOUNT_SERIALIZER, SimpleAmountSerializer::class);

        $this->container->register(self::SERVICE_REFUND_ITEM_SERIALIZER, RefundItemSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LEGACY_REFERENCE_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_SIMPLE_AMOUNT_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_REFUND_ITEMS_SERIALIZER, RefundItemsSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_REFUND_ITEM_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_ISSUE_REFUND_REQUEST_SERIALIZER, IssueRefundRequestSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_REFUND_ITEMS_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_SIMPLE_AMOUNT_SERIALIZER),
                ]
            );
    }

    private function registerOrderTransformers(): void
    {
        $this->container->register(self::SERVICE_AMOUNT_TRANSFORMER, AmountTransformer::class);

        $this->container->register(self::SERVICE_ADDRESS_TRANSFORMER, AddressTransformer::class);

        $this->container->register(self::SERVICE_PHONE_NUMBER_TRANSFORMER, PhoneNumberTransformer::class);

        $this->container->register(self::SERVICE_EXTENDED_CONTACT_TRANSFORMER, ExtendedContactTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ADDRESS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PHONE_NUMBER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_TAX_ADDRESS_TRANSFORMER, TaxAddressTransformer::class);

        $this->container->register(self::SERVICE_TAX_IDENTIFIER_TRANSFORMER, TaxIdentifierTransformer::class);

        $this->container->register(self::SERVICE_BUYER_TRANSFORMER, BuyerTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_EXTENDED_CONTACT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_TAX_ADDRESS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_TAX_IDENTIFIER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CANCEL_REQUEST_TRANSFORMER, CancelRequestTransformer::class);

        $this->container->register(self::SERVICE_CANCEL_REQUESTS_TRANSFORMER, CancelRequestsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CANCEL_REQUEST_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CANCEL_STATUS_TRANSFORMER, CancelStatusTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CANCEL_REQUESTS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PICKUP_STEP_TRANSFORMER, PickupStepTransformer::class);

        $this->container->register(self::SERVICE_SHIPPING_STEP_TRANSFORMER, ShippingStepTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_EXTENDED_CONTACT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_FULFILLMENT_START_INSTRUCTION_TRANSFORMER, FulfillmentStartInstructionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ADDRESS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PICKUP_STEP_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIPPING_STEP_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_FULFILLMENT_START_INSTRUCTIONS_TRANSFORMER, FulfillmentStartInstructionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_FULFILLMENT_START_INSTRUCTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_APPLIED_PROMOTION_TRANSFORMER, AppliedPromotionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_APPLIED_PROMOTIONS_TRANSFORMER, AppliedPromotionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_APPLIED_PROMOTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_DELIVERY_COST_TRANSFORMER, DeliveryCostTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_EBAY_TAX_REFERENCE_TRANSFORMER, EbayTaxReferenceTransformer::class);

        $this->container->register(self::SERVICE_EBAY_COLLECT_AND_REMIT_TAX_TRANSFORMER, EbayCollectAndRemitTaxTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EBAY_TAX_REFERENCE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_EBAY_COLLECT_AND_REMIT_TAXES_TRANSFORMER, EbayCollectAndRemitTaxesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_EBAY_COLLECT_AND_REMIT_TAX_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_EBAY_COLLECTED_CHARGES_TRANSFORMER, EbayCollectedChargesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_GIFT_DETAILS_TRANSFORMER, GiftDetailsTransformer::class);

        $this->container->register(self::SERVICE_ITEM_LOCATION_TRANSFORMER, ItemLocationTransformer::class);

        $this->container->register(self::SERVICE_LINE_ITEM_FULFILLMENT_INSTRUCTIONS_TRANSFORMER, LineItemFulfillmentInstructionsTransformer::class);

        $this->container->register(self::SERVICE_LINE_ITEM_PROPERTIES_TRANSFORMER, LineItemPropertiesTransformer::class);

        $this->container->register(self::SERVICE_LINE_ITEM_REFUND_TRANSFORMER, LineItemRefundTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LINE_ITEM_REFUNDS_TRANSFORMER, LineItemRefundsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_REFUND_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_NAME_VALUE_PAIR_TRANSFORMER, NameValuePairTransformer::class);

        $this->container->register(self::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER, NameValuePairsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_NAME_VALUE_PAIR_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LINKED_ORDER_LINE_ITEM_TRANSFORMER, LinkedOrderLineItemTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_TRACKING_INFOS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LINKED_ORDER_LINE_ITEMS_TRANSFORMER, LinkedOrderLineItemsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINKED_ORDER_LINE_ITEM_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_TAX_TRANSFORMER, TaxTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_TAXES_TRANSFORMER, TaxesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_TAX_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LINE_ITEM_TRANSFORMER, LineItemTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_APPLIED_PROMOTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_DELIVERY_COST_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EBAY_COLLECT_AND_REMIT_TAXES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EBAY_COLLECTED_CHARGES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_GIFT_DETAILS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_FULFILLMENT_INSTRUCTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_PROPERTIES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_REFUNDS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LINKED_ORDER_LINE_ITEMS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_TAXES_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LINE_ITEMS_TRANSFORMER, LineItemsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_REFUND_TRANSFORMER, OrderRefundTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_REFUNDS_TRANSFORMER, OrderRefundsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_REFUND_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SELLER_ACTION_TO_RELEASE_TRANSFORMER, SellerActionToReleaseTransformer::class);

        $this->container->register(self::SERVICE_SELLER_ACTIONS_TO_RELEASE_TRANSFORMER, SellerActionsToReleaseTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SELLER_ACTION_TO_RELEASE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_HOLD_TRANSFORMER, PaymentHoldTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SELLER_ACTIONS_TO_RELEASE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_HOLDS_TRANSFORMER, PaymentHoldsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_HOLD_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_TRANSFORMER, PaymentTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PAYMENT_HOLDS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENTS_TRANSFORMER, PaymentsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_SUMMARY_TRANSFORMER, PaymentSummaryTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ORDER_REFUNDS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PAYMENTS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PRICING_SUMMARY_TRANSFORMER, PricingSummaryTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_EBAY_FULFILLMENT_PROGRAM_TRANSFORMER, EbayFulfillmentProgramTransformer::class);

        $this->container->register(self::SERVICE_EBAY_INTERNATIONAL_SHIPPING_TRANSFORMER, EbayInternationalShippingTransformer::class);

        $this->container->register(self::SERVICE_EBAY_SHIPPING_TRANSFORMER, EbayShippingTransformer::class);

        $this->container->register(self::SERVICE_EBAY_VAULT_PROGRAM_TRANSFORMER, EbayVaultProgramTransformer::class);

        $this->container->register(self::SERVICE_POST_SALE_AUTHENTICATION_PROGRAM_TRANSFORMER, PostSaleAuthenticationProgramTransformer::class);

        $this->container->register(self::SERVICE_PROGRAM_TRANSFORMER, ProgramTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_EBAY_FULFILLMENT_PROGRAM_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EBAY_INTERNATIONAL_SHIPPING_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EBAY_SHIPPING_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EBAY_VAULT_PROGRAM_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_POST_SALE_AUTHENTICATION_PROGRAM_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_TRANSFORMER, OrderTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_BUYER_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CANCEL_STATUS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_FULFILLMENT_START_INSTRUCTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LINE_ITEMS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PAYMENT_SUMMARY_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PRICING_SUMMARY_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PROGRAM_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDERS_TRANSFORMER, OrdersTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_SEARCH_PAGED_COLLECTION_TRANSFORMER, OrderSearchPagedCollectionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERRORS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ORDERS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_REFUND_TRANSFORMER, RefundTransformer::class);
    }

    private function registerPaymentDisputeSerializers(): void
    {
        $this->container->register(self::SERVICE_PHONE_SERIALIZER, PhoneSerializer::class);

        $this->container->register(self::SERVICE_RETURN_ADDRESS_SERIALIZER, ReturnAddressSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PHONE_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_ACCEPT_PAYMENT_DISPUTE_REQUEST_SERIALIZER, AcceptPaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_RETURN_ADDRESS_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_CONTEST_PAYMENT_DISPUTE_REQUEST_SERIALIZER, ContestPaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_RETURN_ADDRESS_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_FILE_EVIDENCE_SERIALIZER, FileEvidenceSerializer::class);

        $this->container->register(self::SERVICE_FILE_EVIDENCES_SERIALIZER, FileEvidencesSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_FILE_EVIDENCE_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_LINE_ITEM_SERIALIZER, OrderLineItemSerializer::class);

        $this->container->register(self::SERVICE_ORDER_LINE_ITEMS_SERIALIZER, OrderLineItemsSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_LINE_ITEM_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER, AddEvidencePaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_FILE_EVIDENCES_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_ORDER_LINE_ITEMS_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_UPDATE_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER, UpdateEvidencePaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_FILE_EVIDENCES_SERIALIZER),
                    $this->container->getDefinition(self::SERVICE_ORDER_LINE_ITEMS_SERIALIZER),
                ]
            );
    }

    private function registerPaymentDisputeTransformers(): void
    {
        $this->container->register(self::SERVICE_FILE_INFO_TRANSFORMER, FileInfoTransformer::class);

        $this->container->register(self::SERVICE_FILE_INFOS_TRANSFORMER, FileInfosTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_FILE_INFO_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_LINE_ITEM_TRANSFORMER, OrderLineItemTransformer::class);

        $this->container->register(self::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER, OrderLineItemsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_LINE_ITEM_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_DISPUTE_EVIDENCE_TRANSFORMER, DisputeEvidenceTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_FILE_INFOS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_TRACKING_INFOS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_DISPUTE_EVIDENCES_TRANSFORMER, DisputeEvidencesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DISPUTE_EVIDENCE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_EVIDENCE_REQUEST_TRANSFORMER, EvidenceRequestTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_EVIDENCE_REQUESTS_TRANSFORMER, EvidenceRequestsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_EVIDENCE_REQUEST_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_INFO_FROM_BUYER_TRANSFORMER, InfoFromBuyerTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_TRACKING_INFOS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_DISPUTE_AMOUNT_TRANSFORMER, DisputeAmountTransformer::class);

        $this->container->register(self::SERVICE_MONETARY_TRANSACTION_TRANSFORMER, MonetaryTransactionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DISPUTE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_MONETARY_TRANSACTIONS_TRANSFORMER, MonetaryTransactionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_MONETARY_TRANSACTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SIMPLE_AMOUNT_TRANSFORMER, SimpleAmountTransformer::class);

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_OUTCOME_DETAIL_TRANSFORMER, PaymentDisputeOutcomeDetailTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SIMPLE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PHONE_TRANSFORMER, PhoneTransformer::class);

        $this->container->register(self::SERVICE_RETURN_ADDRESS_TRANSFORMER, ReturnAddressTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PHONE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_TRANSFORMER, PaymentDisputeTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DISPUTE_EVIDENCES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_EVIDENCE_REQUESTS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_INFO_FROM_BUYER_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_MONETARY_TRANSACTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PAYMENT_DISPUTE_OUTCOME_DETAIL_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_RETURN_ADDRESS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SIMPLE_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_SUMMARY_TRANSFORMER, PaymentDisputeSummaryTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SIMPLE_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_SUMMARIES_TRANSFORMER, PaymentDisputeSummariesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_DISPUTE_SUMMARY_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_DISPUTE_SUMMARY_RESPONSE_TRANSFORMER, DisputeSummaryResponseTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_DISPUTE_SUMMARIES_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_ACTIVITY_TRANSFORMER, PaymentDisputeActivityTransformer::class);

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_ACTIVITIES_TRANSFORMER, PaymentDisputeActivitiesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_DISPUTE_ACTIVITY_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_DISPUTE_ACTIVITY_HISTORY_TRANSFORMER, PaymentDisputeActivityHistoryTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_DISPUTE_ACTIVITIES_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_RESPONSE_TRANSFORMER, AddEvidencePaymentDisputeResponseTransformer::class);

        $this->container->register(self::SERVICE_FILE_EVIDENCE_TRANSFORMER, FileEvidenceTransformer::class);
    }

    private function registerSharedTransformers(): void
    {
        $this->container->register(self::SERVICE_ERROR_PARAMETER_TRANSFORMER, ErrorParameterTransformer::class);

        $this->container->register(self::SERVICE_ERROR_PARAMETERS_TRANSFORMER, ErrorParametersTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERROR_PARAMETER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_STRINGS_TRANSFORMER, StringsTransformer::class);

        $this->container->register(self::SERVICE_ERROR_TRANSFORMER, ErrorTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERROR_PARAMETERS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ERRORS_TRANSFORMER, ErrorsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERROR_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_TRACKING_INFO_TRANSFORMER, TrackingInfoTransformer::class);

        $this->container->register(self::SERVICE_TRACKING_INFOS_TRANSFORMER, TrackingInfosTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_TRACKING_INFO_TRANSFORMER),
                ]
            );
    }

    private function registerShippingFulfillmentSerializers(): void
    {
        $this->container->register(self::SERVICE_LINE_ITEM_REFERENCE_SERIALIZER, LineItemReferenceSerializer::class);

        $this->container->register(self::SERVICE_LINE_ITEM_REFERENCES_SERIALIZER, LineItemReferencesSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_REFERENCE_SERIALIZER),
                ]
            );

        $this->container->register(self::SERVICE_SHIPPING_FULFILLMENT_DETAILS_SERIALIZER, ShippingFulfillmentDetailsSerializer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_REFERENCES_SERIALIZER),
                ]
            );
    }

    private function registerShippingFulfillmentTransformers(): void
    {
        $this->container->register(self::SERVICE_LINE_ITEM_REFERENCE_TRANSFORMER, LineItemReferenceTransformer::class);

        $this->container->register(self::SERVICE_LINE_ITEM_REFERENCES_TRANSFORMER, LineItemReferencesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_REFERENCE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SHIPPING_FULFILLMENT_TRANSFORMER, ShippingFulfillmentTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LINE_ITEM_REFERENCES_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SHIPPING_FULFILLMENTS_TRANSFORMER, ShippingFulfillmentsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SHIPPING_FULFILLMENT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SHIPPING_FULFILLMENT_PAGED_COLLECTION_TRANSFORMER, ShippingFulfillmentPagedCollectionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERRORS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIPPING_FULFILLMENTS_TRANSFORMER),
                ]
            );
    }
}
