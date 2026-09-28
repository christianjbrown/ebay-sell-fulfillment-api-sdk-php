<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests;

use ChristianBrown\EBay\SellFulfillment\Api\OrderApi;
use ChristianBrown\EBay\SellFulfillment\Api\OrderApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApi;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApi;
use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApiInterface;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApi;
use ChristianBrown\EBay\SellFulfillment\Api\ShippingFulfillmentApiInterface;
use ChristianBrown\EBay\SellFulfillment\Auth\Credentials;
use ChristianBrown\EBay\SellFulfillment\Auth\CredentialsInterface;
use ChristianBrown\EBay\SellFulfillment\ContainerFactory;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHost;
use ChristianBrown\EBay\SellFulfillment\Http\MultipartFormDataBuilder;
use ChristianBrown\EBay\SellFulfillment\Registrar\CoreServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\OrderServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\PaymentDisputeEvidenceServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\PaymentDisputeServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\Registrar\ShippingFulfillmentServiceRegistrar;
use ChristianBrown\EBay\SellFulfillment\SellFulfillment;
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
use ChristianBrown\EBay\SellFulfillment\Transformer\AppointmentDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ArrayShapeGuard;
use ChristianBrown\EBay\SellFulfillment\Transformer\BuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelStatusTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ChargeTransformer;
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
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PropertyTransformer;
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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SellFulfillment::class)]
#[UsesClass(AcceptPaymentDisputeRequestSerializer::class)]
#[UsesClass(AddEvidencePaymentDisputeRequestSerializer::class)]
#[UsesClass(AddEvidencePaymentDisputeResponseTransformer::class)]
#[UsesClass(AddressTransformer::class)]
#[UsesClass(AmountTransformer::class)]
#[UsesClass(AppliedPromotionTransformer::class)]
#[UsesClass(AppliedPromotionsTransformer::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(AppointmentDetailsTransformer::class)]
#[UsesClass(ArrayShapeGuard::class)]
#[UsesClass(BuyerTransformer::class)]
#[UsesClass(CancelRequestTransformer::class)]
#[UsesClass(CancelRequestsTransformer::class)]
#[UsesClass(CancelStatusTransformer::class)]
#[UsesClass(ChargeTransformer::class)]
#[UsesClass(ChargesTransformer::class)]
#[UsesClass(ContainerFactory::class)]
#[UsesClass(ContestPaymentDisputeRequestSerializer::class)]
#[UsesClass(CoreServiceRegistrar::class)]
#[UsesClass(Credentials::class)]
#[UsesClass(DeliveryCostTransformer::class)]
#[UsesClass(DisputeAmountTransformer::class)]
#[UsesClass(DisputeEvidenceTransformer::class)]
#[UsesClass(DisputeEvidencesTransformer::class)]
#[UsesClass(DisputeSummaryResponseTransformer::class)]
#[UsesClass(EbayCollectAndRemitTaxTransformer::class)]
#[UsesClass(EbayCollectAndRemitTaxesTransformer::class)]
#[UsesClass(EbayCollectedChargesTransformer::class)]
#[UsesClass(EbayFulfillmentProgramTransformer::class)]
#[UsesClass(EbayInternationalShippingTransformer::class)]
#[UsesClass(EbayShippingTransformer::class)]
#[UsesClass(EbayTaxReferenceTransformer::class)]
#[UsesClass(EbayVaultProgramTransformer::class)]
#[UsesClass(ErrorParameterTransformer::class)]
#[UsesClass(ErrorParametersTransformer::class)]
#[UsesClass(ErrorTransformer::class)]
#[UsesClass(ErrorsTransformer::class)]
#[UsesClass(EvidenceRequestTransformer::class)]
#[UsesClass(EvidenceRequestsTransformer::class)]
#[UsesClass(ExtendedContactTransformer::class)]
#[UsesClass(FileEvidenceSerializer::class)]
#[UsesClass(FileEvidenceTransformer::class)]
#[UsesClass(FileEvidencesSerializer::class)]
#[UsesClass(FileInfoTransformer::class)]
#[UsesClass(FileInfosTransformer::class)]
#[UsesClass(FulfillmentStartInstructionTransformer::class)]
#[UsesClass(FulfillmentStartInstructionsTransformer::class)]
#[UsesClass(GiftDetailsTransformer::class)]
#[UsesClass(InfoFromBuyerTransformer::class)]
#[UsesClass(IssueRefundRequestSerializer::class)]
#[UsesClass(ItemLocationTransformer::class)]
#[UsesClass(LegacyReferenceSerializer::class)]
#[UsesClass(LineItemFulfillmentInstructionsTransformer::class)]
#[UsesClass(LineItemPropertiesTransformer::class)]
#[UsesClass(LineItemReferenceSerializer::class)]
#[UsesClass(LineItemReferenceTransformer::class)]
#[UsesClass(LineItemReferencesSerializer::class)]
#[UsesClass(LineItemReferencesTransformer::class)]
#[UsesClass(LineItemRefundTransformer::class)]
#[UsesClass(LineItemRefundsTransformer::class)]
#[UsesClass(LineItemTransformer::class)]
#[UsesClass(LineItemsTransformer::class)]
#[UsesClass(LinkedOrderLineItemTransformer::class)]
#[UsesClass(LinkedOrderLineItemsTransformer::class)]
#[UsesClass(MonetaryTransactionTransformer::class)]
#[UsesClass(MonetaryTransactionsTransformer::class)]
#[UsesClass(MultipartFormDataBuilder::class)]
#[UsesClass(NameValuePairTransformer::class)]
#[UsesClass(NameValuePairsTransformer::class)]
#[UsesClass(OrderApi::class)]
#[UsesClass(OrderLineItemSerializer::class)]
#[UsesClass(OrderLineItemTransformer::class)]
#[UsesClass(OrderLineItemsSerializer::class)]
#[UsesClass(OrderLineItemsTransformer::class)]
#[UsesClass(OrderRefundTransformer::class)]
#[UsesClass(OrderRefundsTransformer::class)]
#[UsesClass(OrderSearchPagedCollectionTransformer::class)]
#[UsesClass(OrderServiceRegistrar::class)]
#[UsesClass(OrderTransformer::class)]
#[UsesClass(OrdersTransformer::class)]
#[UsesClass(PaymentDisputeActivitiesTransformer::class)]
#[UsesClass(PaymentDisputeActivityHistoryTransformer::class)]
#[UsesClass(PaymentDisputeActivityTransformer::class)]
#[UsesClass(PaymentDisputeApi::class)]
#[UsesClass(PaymentDisputeEvidenceApi::class)]
#[UsesClass(PaymentDisputeEvidenceServiceRegistrar::class)]
#[UsesClass(PaymentDisputeOutcomeDetailTransformer::class)]
#[UsesClass(PaymentDisputeServiceRegistrar::class)]
#[UsesClass(PaymentDisputeSummariesTransformer::class)]
#[UsesClass(PaymentDisputeSummaryTransformer::class)]
#[UsesClass(PaymentDisputeTransformer::class)]
#[UsesClass(PaymentHoldTransformer::class)]
#[UsesClass(PaymentHoldsTransformer::class)]
#[UsesClass(PaymentSummaryTransformer::class)]
#[UsesClass(PaymentTransformer::class)]
#[UsesClass(PaymentsTransformer::class)]
#[UsesClass(PhoneNumberTransformer::class)]
#[UsesClass(PhoneSerializer::class)]
#[UsesClass(PhoneTransformer::class)]
#[UsesClass(PickupStepTransformer::class)]
#[UsesClass(PostSaleAuthenticationProgramTransformer::class)]
#[UsesClass(PricingSummaryTransformer::class)]
#[UsesClass(ProgramTransformer::class)]
#[UsesClass(PropertiesTransformer::class)]
#[UsesClass(PropertyTransformer::class)]
#[UsesClass(RefundItemSerializer::class)]
#[UsesClass(RefundItemsSerializer::class)]
#[UsesClass(RefundTransformer::class)]
#[UsesClass(ReturnAddressSerializer::class)]
#[UsesClass(ReturnAddressTransformer::class)]
#[UsesClass(SellerActionToReleaseTransformer::class)]
#[UsesClass(SellerActionsToReleaseTransformer::class)]
#[UsesClass(ShippingFulfillmentApi::class)]
#[UsesClass(ShippingFulfillmentDetailsSerializer::class)]
#[UsesClass(ShippingFulfillmentPagedCollectionTransformer::class)]
#[UsesClass(ShippingFulfillmentServiceRegistrar::class)]
#[UsesClass(ShippingFulfillmentTransformer::class)]
#[UsesClass(ShippingFulfillmentsTransformer::class)]
#[UsesClass(ShippingStepTransformer::class)]
#[UsesClass(SimpleAmountSerializer::class)]
#[UsesClass(SimpleAmountTransformer::class)]
#[UsesClass(StringsTransformer::class)]
#[UsesClass(TaxAddressTransformer::class)]
#[UsesClass(TaxIdentifierTransformer::class)]
#[UsesClass(TaxTransformer::class)]
#[UsesClass(TaxesTransformer::class)]
#[UsesClass(TrackingInfoTransformer::class)]
#[UsesClass(TrackingInfosTransformer::class)]
#[UsesClass(UpdateEvidencePaymentDisputeRequestSerializer::class)]
final class SellFulfillmentTest extends TestCase
{
    public function testGetOrderApi(): void
    {
        self::assertInstanceOf(OrderApiInterface::class, $this->buildSellFulfillment()->getOrderApi());
    }

    public function testGetOrderApiReturnsSharedInstance(): void
    {
        $sellFulfillment = $this->buildSellFulfillment();

        self::assertSame($sellFulfillment->getOrderApi(), $sellFulfillment->getOrderApi());
    }

    public function testGetPaymentDisputeApi(): void
    {
        self::assertInstanceOf(PaymentDisputeApiInterface::class, $this->buildSellFulfillment()->getPaymentDisputeApi());
    }

    public function testGetPaymentDisputeApiReturnsSharedInstance(): void
    {
        $sellFulfillment = $this->buildSellFulfillment();

        self::assertSame($sellFulfillment->getPaymentDisputeApi(), $sellFulfillment->getPaymentDisputeApi());
    }

    public function testGetPaymentDisputeEvidenceApi(): void
    {
        self::assertInstanceOf(PaymentDisputeEvidenceApiInterface::class, $this->buildSellFulfillment()->getPaymentDisputeEvidenceApi());
    }

    public function testGetPaymentDisputeEvidenceApiReturnsSharedInstance(): void
    {
        $sellFulfillment = $this->buildSellFulfillment();

        self::assertSame($sellFulfillment->getPaymentDisputeEvidenceApi(), $sellFulfillment->getPaymentDisputeEvidenceApi());
    }

    public function testGetShippingFulfillmentApi(): void
    {
        self::assertInstanceOf(ShippingFulfillmentApiInterface::class, $this->buildSellFulfillment()->getShippingFulfillmentApi());
    }

    public function testGetShippingFulfillmentApiReturnsSharedInstance(): void
    {
        $sellFulfillment = $this->buildSellFulfillment();

        self::assertSame($sellFulfillment->getShippingFulfillmentApi(), $sellFulfillment->getShippingFulfillmentApi());
    }

    public function testWiresWithALock(): void
    {
        $sellFulfillment = new SellFulfillment(
            'test-app-id',
            'test-cert-id',
            CredentialsInterface::MARKETPLACE_ID_EBAY_GB,
            self::createStub(TtlAwareKeyValueStoreInterface::class),
            self::createStub(KeyValueStoreInterface::class),
            self::createStub(LockInterface::class),
        );

        self::assertInstanceOf(OrderApiInterface::class, $sellFulfillment->getOrderApi());
    }

    private function buildSellFulfillment(): SellFulfillment
    {
        return new SellFulfillment(
            'test-app-id',
            'test-cert-id',
            CredentialsInterface::MARKETPLACE_ID_EBAY_GB,
            self::createStub(TtlAwareKeyValueStoreInterface::class),
            self::createStub(KeyValueStoreInterface::class),
        );
    }
}
