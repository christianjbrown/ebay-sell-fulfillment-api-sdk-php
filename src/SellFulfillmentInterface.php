<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApiInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

interface SellFulfillmentInterface
{
    public const string OAUTH_SCOPE_SELL_FULFILLMENT = 'https://api.ebay.com/oauth/api_scope/sell.fulfillment';
    public const string OAUTH_SCOPE_SELL_FULFILLMENT_READONLY = 'https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly';
    public const string OAUTH_TOKEN_URL = 'https://api.ebay.com/identity/v1/oauth2/token';
    public const string SERVICE_ACCEPT_PAYMENT_DISPUTE_REQUEST_SERIALIZER = 'ebay_sell_fulfillment.serializer.accept_payment_dispute_request_serializer';
    public const string SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER = 'ebay_sell_fulfillment.serializer.add_evidence_payment_dispute_request_serializer';
    public const string SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_RESPONSE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.add_evidence_payment_dispute_response_transformer';
    public const string SERVICE_ADDRESS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.address_transformer';
    public const string SERVICE_AMOUNT_TRANSFORMER = 'ebay_sell_fulfillment.transformer.amount_transformer';
    public const string SERVICE_API_CLIENT = 'ebay_sell_fulfillment.api_client';
    public const string SERVICE_API_REQUEST_SENDER = 'ebay_sell_fulfillment.api_request_sender';
    public const string SERVICE_APPLIED_PROMOTION_TRANSFORMER = 'ebay_sell_fulfillment.transformer.applied_promotion_transformer';
    public const string SERVICE_APPLIED_PROMOTIONS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.applied_promotions_transformer';
    public const string SERVICE_APPOINTMENT_DETAILS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.appointment_details_transformer';
    public const string SERVICE_ARRAY_SHAPE_GUARD = 'ebay_sell_fulfillment.transformer.array_shape_guard';
    public const string SERVICE_ARRAY_TO_JSON_TRANSFORMER = 'ebay_sell_fulfillment.array_to_json_transformer';
    public const string SERVICE_BUYER_TRANSFORMER = 'ebay_sell_fulfillment.transformer.buyer_transformer';
    public const string SERVICE_CANCEL_REQUEST_TRANSFORMER = 'ebay_sell_fulfillment.transformer.cancel_request_transformer';
    public const string SERVICE_CANCEL_REQUESTS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.cancel_requests_transformer';
    public const string SERVICE_CANCEL_STATUS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.cancel_status_transformer';
    public const string SERVICE_CHARGE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.charge_transformer';
    public const string SERVICE_CHARGES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.charges_transformer';
    public const string SERVICE_CLIENT_AUTHENTICATION = 'ebay_sell_fulfillment.oauth.client_authentication';
    public const string SERVICE_CONTEST_PAYMENT_DISPUTE_REQUEST_SERIALIZER = 'ebay_sell_fulfillment.serializer.contest_payment_dispute_request_serializer';
    public const string SERVICE_CREDENTIALS = 'ebay_sell_fulfillment.auth.credentials';
    public const string SERVICE_DELIVERY_COST_TRANSFORMER = 'ebay_sell_fulfillment.transformer.delivery_cost_transformer';
    public const string SERVICE_DISPUTE_AMOUNT_TRANSFORMER = 'ebay_sell_fulfillment.transformer.dispute_amount_transformer';
    public const string SERVICE_DISPUTE_EVIDENCE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.dispute_evidence_transformer';
    public const string SERVICE_DISPUTE_EVIDENCES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.dispute_evidences_transformer';
    public const string SERVICE_DISPUTE_SUMMARY_RESPONSE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.dispute_summary_response_transformer';
    public const string SERVICE_EBAY_COLLECT_AND_REMIT_TAX_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_collect_and_remit_tax_transformer';
    public const string SERVICE_EBAY_COLLECT_AND_REMIT_TAXES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_collect_and_remit_taxes_transformer';
    public const string SERVICE_EBAY_COLLECTED_CHARGES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_collected_charges_transformer';
    public const string SERVICE_EBAY_FULFILLMENT_PROGRAM_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_fulfillment_program_transformer';
    public const string SERVICE_EBAY_INTERNATIONAL_SHIPPING_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_international_shipping_transformer';
    public const string SERVICE_EBAY_SHIPPING_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_shipping_transformer';
    public const string SERVICE_EBAY_TAX_REFERENCE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_tax_reference_transformer';
    public const string SERVICE_EBAY_VAULT_PROGRAM_TRANSFORMER = 'ebay_sell_fulfillment.transformer.ebay_vault_program_transformer';
    public const string SERVICE_ERROR_PARAMETER_TRANSFORMER = 'ebay_sell_fulfillment.transformer.error_parameter_transformer';
    public const string SERVICE_ERROR_PARAMETERS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.error_parameters_transformer';
    public const string SERVICE_ERROR_TRANSFORMER = 'ebay_sell_fulfillment.transformer.error_transformer';
    public const string SERVICE_ERRORS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.errors_transformer';
    public const string SERVICE_EVIDENCE_REQUEST_TRANSFORMER = 'ebay_sell_fulfillment.transformer.evidence_request_transformer';
    public const string SERVICE_EVIDENCE_REQUESTS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.evidence_requests_transformer';
    public const string SERVICE_EXTENDED_CONTACT_TRANSFORMER = 'ebay_sell_fulfillment.transformer.extended_contact_transformer';
    public const string SERVICE_FILE_EVIDENCE_SERIALIZER = 'ebay_sell_fulfillment.serializer.file_evidence_serializer';
    public const string SERVICE_FILE_EVIDENCE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.file_evidence_transformer';
    public const string SERVICE_FILE_EVIDENCES_SERIALIZER = 'ebay_sell_fulfillment.serializer.file_evidences_serializer';
    public const string SERVICE_FILE_INFO_TRANSFORMER = 'ebay_sell_fulfillment.transformer.file_info_transformer';
    public const string SERVICE_FILE_INFOS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.file_infos_transformer';
    public const string SERVICE_FULFILLMENT_START_INSTRUCTION_TRANSFORMER = 'ebay_sell_fulfillment.transformer.fulfillment_start_instruction_transformer';
    public const string SERVICE_FULFILLMENT_START_INSTRUCTIONS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.fulfillment_start_instructions_transformer';
    public const string SERVICE_GIFT_DETAILS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.gift_details_transformer';
    public const string SERVICE_INFO_FROM_BUYER_TRANSFORMER = 'ebay_sell_fulfillment.transformer.info_from_buyer_transformer';
    public const string SERVICE_ISSUE_REFUND_REQUEST_SERIALIZER = 'ebay_sell_fulfillment.serializer.issue_refund_request_serializer';
    public const string SERVICE_ITEM_LOCATION_TRANSFORMER = 'ebay_sell_fulfillment.transformer.item_location_transformer';
    public const string SERVICE_JSON_API_REQUEST_SENDER = 'ebay_sell_fulfillment.json_api_request_sender';
    public const string SERVICE_LEGACY_REFERENCE_SERIALIZER = 'ebay_sell_fulfillment.serializer.legacy_reference_serializer';
    public const string SERVICE_LINE_ITEM_FULFILLMENT_INSTRUCTIONS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_item_fulfillment_instructions_transformer';
    public const string SERVICE_LINE_ITEM_PROPERTIES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_item_properties_transformer';
    public const string SERVICE_LINE_ITEM_REFERENCE_SERIALIZER = 'ebay_sell_fulfillment.serializer.line_item_reference_serializer';
    public const string SERVICE_LINE_ITEM_REFERENCE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_item_reference_transformer';
    public const string SERVICE_LINE_ITEM_REFERENCES_SERIALIZER = 'ebay_sell_fulfillment.serializer.line_item_references_serializer';
    public const string SERVICE_LINE_ITEM_REFERENCES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_item_references_transformer';
    public const string SERVICE_LINE_ITEM_REFUND_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_item_refund_transformer';
    public const string SERVICE_LINE_ITEM_REFUNDS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_item_refunds_transformer';
    public const string SERVICE_LINE_ITEM_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_item_transformer';
    public const string SERVICE_LINE_ITEMS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.line_items_transformer';
    public const string SERVICE_LINKED_ORDER_LINE_ITEM_TRANSFORMER = 'ebay_sell_fulfillment.transformer.linked_order_line_item_transformer';
    public const string SERVICE_LINKED_ORDER_LINE_ITEMS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.linked_order_line_items_transformer';
    public const string SERVICE_MONETARY_TRANSACTION_TRANSFORMER = 'ebay_sell_fulfillment.transformer.monetary_transaction_transformer';
    public const string SERVICE_MONETARY_TRANSACTIONS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.monetary_transactions_transformer';
    public const string SERVICE_NAME_VALUE_PAIR_TRANSFORMER = 'ebay_sell_fulfillment.transformer.name_value_pair_transformer';
    public const string SERVICE_NAME_VALUE_PAIRS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.name_value_pairs_transformer';
    public const string SERVICE_ORDER_API = 'ebay_sell_fulfillment.api.order_api';
    public const string SERVICE_ORDER_LINE_ITEM_SERIALIZER = 'ebay_sell_fulfillment.serializer.order_line_item_serializer';
    public const string SERVICE_ORDER_LINE_ITEM_TRANSFORMER = 'ebay_sell_fulfillment.transformer.order_line_item_transformer';
    public const string SERVICE_ORDER_LINE_ITEMS_SERIALIZER = 'ebay_sell_fulfillment.serializer.order_line_items_serializer';
    public const string SERVICE_ORDER_LINE_ITEMS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.order_line_items_transformer';
    public const string SERVICE_ORDER_REFUND_TRANSFORMER = 'ebay_sell_fulfillment.transformer.order_refund_transformer';
    public const string SERVICE_ORDER_REFUNDS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.order_refunds_transformer';
    public const string SERVICE_ORDER_SEARCH_PAGED_COLLECTION_TRANSFORMER = 'ebay_sell_fulfillment.transformer.order_search_paged_collection_transformer';
    public const string SERVICE_ORDER_TRANSFORMER = 'ebay_sell_fulfillment.transformer.order_transformer';
    public const string SERVICE_ORDERS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.orders_transformer';
    public const string SERVICE_PAYMENT_DISPUTE_ACTIVITIES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_dispute_activities_transformer';
    public const string SERVICE_PAYMENT_DISPUTE_ACTIVITY_HISTORY_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_dispute_activity_history_transformer';
    public const string SERVICE_PAYMENT_DISPUTE_ACTIVITY_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_dispute_activity_transformer';
    public const string SERVICE_PAYMENT_DISPUTE_API = 'ebay_sell_fulfillment.api.payment_dispute_api';
    public const string SERVICE_PAYMENT_DISPUTE_EVIDENCE_API = 'ebay_sell_fulfillment.api.payment_dispute_evidence_api';
    public const string SERVICE_PAYMENT_DISPUTE_OUTCOME_DETAIL_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_dispute_outcome_detail_transformer';
    public const string SERVICE_PAYMENT_DISPUTE_SUMMARIES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_dispute_summaries_transformer';
    public const string SERVICE_PAYMENT_DISPUTE_SUMMARY_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_dispute_summary_transformer';
    public const string SERVICE_PAYMENT_DISPUTE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_dispute_transformer';
    public const string SERVICE_PAYMENT_HOLD_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_hold_transformer';
    public const string SERVICE_PAYMENT_HOLDS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_holds_transformer';
    public const string SERVICE_PAYMENT_SUMMARY_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_summary_transformer';
    public const string SERVICE_PAYMENT_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payment_transformer';
    public const string SERVICE_PAYMENTS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.payments_transformer';
    public const string SERVICE_PHONE_NUMBER_TRANSFORMER = 'ebay_sell_fulfillment.transformer.phone_number_transformer';
    public const string SERVICE_PHONE_SERIALIZER = 'ebay_sell_fulfillment.serializer.phone_serializer';
    public const string SERVICE_PHONE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.phone_transformer';
    public const string SERVICE_PICKUP_STEP_TRANSFORMER = 'ebay_sell_fulfillment.transformer.pickup_step_transformer';
    public const string SERVICE_POST_SALE_AUTHENTICATION_PROGRAM_TRANSFORMER = 'ebay_sell_fulfillment.transformer.post_sale_authentication_program_transformer';
    public const string SERVICE_PRICING_SUMMARY_TRANSFORMER = 'ebay_sell_fulfillment.transformer.pricing_summary_transformer';
    public const string SERVICE_PROGRAM_TRANSFORMER = 'ebay_sell_fulfillment.transformer.program_transformer';
    public const string SERVICE_PROPERTIES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.properties_transformer';
    public const string SERVICE_PROPERTY_TRANSFORMER = 'ebay_sell_fulfillment.transformer.property_transformer';
    public const string SERVICE_REFRESH_TOKEN_MANAGER = 'ebay_sell_fulfillment.oauth.refresh_token_manager';
    public const string SERVICE_REFUND_ITEM_SERIALIZER = 'ebay_sell_fulfillment.serializer.refund_item_serializer';
    public const string SERVICE_REFUND_ITEMS_SERIALIZER = 'ebay_sell_fulfillment.serializer.refund_items_serializer';
    public const string SERVICE_REFUND_TRANSFORMER = 'ebay_sell_fulfillment.transformer.refund_transformer';
    public const string SERVICE_RETURN_ADDRESS_SERIALIZER = 'ebay_sell_fulfillment.serializer.return_address_serializer';
    public const string SERVICE_RETURN_ADDRESS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.return_address_transformer';
    public const string SERVICE_SELLER_ACTION_TO_RELEASE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.seller_action_to_release_transformer';
    public const string SERVICE_SELLER_ACTIONS_TO_RELEASE_TRANSFORMER = 'ebay_sell_fulfillment.transformer.seller_actions_to_release_transformer';
    public const string SERVICE_SHIPPING_FULFILLMENT_API = 'ebay_sell_fulfillment.api.shipping_fulfillment_api';
    public const string SERVICE_SHIPPING_FULFILLMENT_DETAILS_SERIALIZER = 'ebay_sell_fulfillment.serializer.shipping_fulfillment_details_serializer';
    public const string SERVICE_SHIPPING_FULFILLMENT_PAGED_COLLECTION_TRANSFORMER = 'ebay_sell_fulfillment.transformer.shipping_fulfillment_paged_collection_transformer';
    public const string SERVICE_SHIPPING_FULFILLMENT_TRANSFORMER = 'ebay_sell_fulfillment.transformer.shipping_fulfillment_transformer';
    public const string SERVICE_SHIPPING_FULFILLMENTS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.shipping_fulfillments_transformer';
    public const string SERVICE_SHIPPING_STEP_TRANSFORMER = 'ebay_sell_fulfillment.transformer.shipping_step_transformer';
    public const string SERVICE_SIMPLE_AMOUNT_SERIALIZER = 'ebay_sell_fulfillment.serializer.simple_amount_serializer';
    public const string SERVICE_SIMPLE_AMOUNT_TRANSFORMER = 'ebay_sell_fulfillment.transformer.simple_amount_transformer';
    public const string SERVICE_STRINGS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.strings_transformer';
    public const string SERVICE_TAX_ADDRESS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.tax_address_transformer';
    public const string SERVICE_TAX_IDENTIFIER_TRANSFORMER = 'ebay_sell_fulfillment.transformer.tax_identifier_transformer';
    public const string SERVICE_TAX_TRANSFORMER = 'ebay_sell_fulfillment.transformer.tax_transformer';
    public const string SERVICE_TAXES_TRANSFORMER = 'ebay_sell_fulfillment.transformer.taxes_transformer';
    public const string SERVICE_TRACKING_INFO_TRANSFORMER = 'ebay_sell_fulfillment.transformer.tracking_info_transformer';
    public const string SERVICE_TRACKING_INFOS_TRANSFORMER = 'ebay_sell_fulfillment.transformer.tracking_infos_transformer';
    public const string SERVICE_UPDATE_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER = 'ebay_sell_fulfillment.serializer.update_evidence_payment_dispute_request_serializer';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getOrderApi(): OrderApiInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPaymentDisputeApi(): PaymentDisputeApiInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPaymentDisputeEvidenceApi(): PaymentDisputeEvidenceApiInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getShippingFulfillmentApi(): ShippingFulfillmentApiInterface;
}
