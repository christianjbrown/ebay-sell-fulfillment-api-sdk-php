<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeApi;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\AcceptPaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ContestPaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\PhoneSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ReturnAddressSerializer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeAmountTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidencesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeEvidenceTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\DisputeSummaryResponseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\EvidenceRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfosTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileInfoTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\InfoFromBuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\MonetaryTransactionTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\OrderLineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivitiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityHistoryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeActivityTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeOutcomeDetailTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummariesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeSummaryTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PaymentDisputeTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ReturnAddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\SimpleAmountTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers everything `getPaymentDisputeApi()` needs: the payment-dispute
 * transformer and serializer chains, then `PaymentDisputeApi` itself. Must
 * run after {@see CoreServiceRegistrar}.
 */
final class PaymentDisputeServiceRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        self::registerTransformers($container);
        self::registerSerializers($container);
        $this->registerApiClient($container);
    }

    private function registerApiClient(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_API, PaymentDisputeApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_API_REQUEST_SENDER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_TO_JSON_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_ACTIVITY_HISTORY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_DISPUTE_SUMMARY_RESPONSE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ACCEPT_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CONTEST_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CREDENTIALS),
                    $this->apiHost,
                ]
            );
    }

    private static function registerSerializers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_PHONE_SERIALIZER, PhoneSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_RETURN_ADDRESS_SERIALIZER, ReturnAddressSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PHONE_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ACCEPT_PAYMENT_DISPUTE_REQUEST_SERIALIZER, AcceptPaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_RETURN_ADDRESS_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_CONTEST_PAYMENT_DISPUTE_REQUEST_SERIALIZER, ContestPaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_RETURN_ADDRESS_SERIALIZER),
                ]
            );
    }

    private static function registerTransformers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_FILE_INFO_TRANSFORMER, FileInfoTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_FILE_INFOS_TRANSFORMER, FileInfosTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FILE_INFO_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEM_TRANSFORMER, OrderLineItemTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER, OrderLineItemsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEM_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_DISPUTE_EVIDENCE_TRANSFORMER, DisputeEvidenceTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FILE_INFOS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TRACKING_INFOS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_DISPUTE_EVIDENCES_TRANSFORMER, DisputeEvidencesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_DISPUTE_EVIDENCE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EVIDENCE_REQUEST_TRANSFORMER, EvidenceRequestTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_EVIDENCE_REQUESTS_TRANSFORMER, EvidenceRequestsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EVIDENCE_REQUEST_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_INFO_FROM_BUYER_TRANSFORMER, InfoFromBuyerTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_TRACKING_INFOS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_DISPUTE_AMOUNT_TRANSFORMER, DisputeAmountTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_MONETARY_TRANSACTION_TRANSFORMER, MonetaryTransactionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_DISPUTE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_MONETARY_TRANSACTIONS_TRANSFORMER, MonetaryTransactionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_MONETARY_TRANSACTION_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_TRANSFORMER, SimpleAmountTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_OUTCOME_DETAIL_TRANSFORMER, PaymentDisputeOutcomeDetailTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PHONE_TRANSFORMER, PhoneTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_RETURN_ADDRESS_TRANSFORMER, ReturnAddressTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PHONE_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_TRANSFORMER, PaymentDisputeTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_DISPUTE_EVIDENCES_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_EVIDENCE_REQUESTS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_INFO_FROM_BUYER_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_MONETARY_TRANSACTIONS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEMS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_OUTCOME_DETAIL_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_RETURN_ADDRESS_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_SUMMARY_TRANSFORMER, PaymentDisputeSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_SIMPLE_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_SUMMARIES_TRANSFORMER, PaymentDisputeSummariesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_SUMMARY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_DISPUTE_SUMMARY_RESPONSE_TRANSFORMER, DisputeSummaryResponseTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_SUMMARIES_TRANSFORMER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_ACTIVITY_TRANSFORMER, PaymentDisputeActivityTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_ACTIVITIES_TRANSFORMER, PaymentDisputeActivitiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_ACTIVITY_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_SHAPE_GUARD),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_ACTIVITY_HISTORY_TRANSFORMER, PaymentDisputeActivityHistoryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_ACTIVITIES_TRANSFORMER),
                ]
            );
    }
}
