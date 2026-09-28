<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\Api\OrderApi;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\IssueRefundRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\LegacyReferenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\RefundItemsSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\SimpleAmountSerializer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppointmentDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\BuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelStatusTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargeTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DeliveryCostTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectedChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayFulfillmentProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayInternationalShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayShippingTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayTaxReferenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayVaultProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ExtendedContactTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FulfillmentStartInstructionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\GiftDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemFulfillmentInstructionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemPropertiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderRefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderSearchPagedCollectionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrdersTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentHoldTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneNumberTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PickupStepTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PostSaleAuthenticationProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PricingSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertyTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\RefundTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionsToReleaseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SellerActionToReleaseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ShippingStepTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxAddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxIdentifierTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers everything `getOrderApi()` needs: the order transformer and
 * serializer chains, then `OrderApi` itself. Must run after
 * {@see CoreServiceRegistrar}.
 */
final class OrderServiceRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        self::registerSerializers($container);
        self::registerTransformers($container);
        $this->registerApiClient($container);
    }

    private function registerApiClient(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_ORDER_API, OrderApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_SEARCH_PAGED_COLLECTION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_REFUND_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ISSUE_REFUND_REQUEST_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CREDENTIALS),
                    $this->apiHost,
                ]
            );
    }

    private static function registerSerializers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_LEGACY_REFERENCE_SERIALIZER, LegacyReferenceSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_SERIALIZER, SimpleAmountSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_REFUND_ITEM_SERIALIZER, RefundItemSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LEGACY_REFERENCE_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_REFUND_ITEMS_SERIALIZER, RefundItemsSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_REFUND_ITEM_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ISSUE_REFUND_REQUEST_SERIALIZER, IssueRefundRequestSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_REFUND_ITEMS_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_SERIALIZER),
                ]
            );
    }

    private static function registerTransformers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER, AmountTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_ADDRESS_TRANSFORMER, AddressTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PHONE_NUMBER_TRANSFORMER, PhoneNumberTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EXTENDED_CONTACT_TRANSFORMER, ExtendedContactTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ADDRESS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PHONE_NUMBER_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_TAX_ADDRESS_TRANSFORMER, TaxAddressTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_TAX_IDENTIFIER_TRANSFORMER, TaxIdentifierTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_BUYER_TRANSFORMER, BuyerTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EXTENDED_CONTACT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAX_ADDRESS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAX_IDENTIFIER_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_CANCEL_REQUEST_TRANSFORMER, CancelRequestTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_CANCEL_REQUESTS_TRANSFORMER, CancelRequestsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CANCEL_REQUEST_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_CANCEL_STATUS_TRANSFORMER, CancelStatusTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CANCEL_REQUESTS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PROPERTY_TRANSFORMER, PropertyTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PROPERTIES_TRANSFORMER, PropertiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PROPERTY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_CHARGE_TRANSFORMER, ChargeTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_CHARGES_TRANSFORMER, ChargesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CHARGE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_APPOINTMENT_DETAILS_TRANSFORMER, AppointmentDetailsTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PICKUP_STEP_TRANSFORMER, PickupStepTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_SHIPPING_STEP_TRANSFORMER, ShippingStepTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EXTENDED_CONTACT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTION_TRANSFORMER, FulfillmentStartInstructionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ADDRESS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PICKUP_STEP_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SHIPPING_STEP_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_APPOINTMENT_DETAILS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTIONS_TRANSFORMER, FulfillmentStartInstructionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTION_TRANSFORMER, AppliedPromotionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTIONS_TRANSFORMER, AppliedPromotionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_DELIVERY_COST_TRANSFORMER, DeliveryCostTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_TAX_REFERENCE_TRANSFORMER, EbayTaxReferenceTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAX_TRANSFORMER, EbayCollectAndRemitTaxTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_TAX_REFERENCE_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAXES_TRANSFORMER, EbayCollectAndRemitTaxesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAX_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_COLLECTED_CHARGES_TRANSFORMER, EbayCollectedChargesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CHARGES_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_GIFT_DETAILS_TRANSFORMER, GiftDetailsTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_ITEM_LOCATION_TRANSFORMER, ItemLocationTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_FULFILLMENT_INSTRUCTIONS_TRANSFORMER, LineItemFulfillmentInstructionsTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_PROPERTIES_TRANSFORMER, LineItemPropertiesTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUND_TRANSFORMER, LineItemRefundTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUNDS_TRANSFORMER, LineItemRefundsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUND_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIR_TRANSFORMER, NameValuePairTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER, NameValuePairsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIR_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEM_TRANSFORMER, LinkedOrderLineItemTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TRACKING_INFOS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEMS_TRANSFORMER, LinkedOrderLineItemsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_TAX_TRANSFORMER, TaxTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_TAXES_TRANSFORMER, TaxesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAX_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEM_TRANSFORMER, LineItemTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_APPLIED_PROMOTIONS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_DELIVERY_COST_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_COLLECT_AND_REMIT_TAXES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_COLLECTED_CHARGES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_GIFT_DETAILS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_FULFILLMENT_INSTRUCTIONS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_PROPERTIES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_REFUNDS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINKED_ORDER_LINE_ITEMS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_NAME_VALUE_PAIRS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TAXES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PROPERTIES_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_LINE_ITEMS_TRANSFORMER, LineItemsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_REFUND_TRANSFORMER, OrderRefundTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_REFUNDS_TRANSFORMER, OrderRefundsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_REFUND_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_SELLER_ACTION_TO_RELEASE_TRANSFORMER, SellerActionToReleaseTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_SELLER_ACTIONS_TO_RELEASE_TRANSFORMER, SellerActionsToReleaseTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SELLER_ACTION_TO_RELEASE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_HOLD_TRANSFORMER, PaymentHoldTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SELLER_ACTIONS_TO_RELEASE_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_HOLDS_TRANSFORMER, PaymentHoldsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_HOLD_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_TRANSFORMER, PaymentTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_HOLDS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENTS_TRANSFORMER, PaymentsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_SUMMARY_TRANSFORMER, PaymentSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_REFUNDS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENTS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PRICING_SUMMARY_TRANSFORMER, PricingSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_FULFILLMENT_PROGRAM_TRANSFORMER, EbayFulfillmentProgramTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_INTERNATIONAL_SHIPPING_TRANSFORMER, EbayInternationalShippingTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_SHIPPING_TRANSFORMER, EbayShippingTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_EBAY_VAULT_PROGRAM_TRANSFORMER, EbayVaultProgramTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_POST_SALE_AUTHENTICATION_PROGRAM_TRANSFORMER, PostSaleAuthenticationProgramTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PROGRAM_TRANSFORMER, ProgramTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_FULFILLMENT_PROGRAM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_INTERNATIONAL_SHIPPING_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_SHIPPING_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EBAY_VAULT_PROGRAM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_POST_SALE_AUTHENTICATION_PROGRAM_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_TRANSFORMER, OrderTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_BUYER_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CANCEL_STATUS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FULFILLMENT_START_INSTRUCTIONS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_LINE_ITEMS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_SUMMARY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PRICING_SUMMARY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PROGRAM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDERS_TRANSFORMER, OrdersTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_SEARCH_PAGED_COLLECTION_TRANSFORMER, OrderSearchPagedCollectionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDERS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_REFUND_TRANSFORMER, RefundTransformer::class);
    }
}
