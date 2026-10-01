<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\Api\PaymentDisputeEvidenceApi;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\AddEvidencePaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidenceSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidencesSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemsSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\UpdateEvidencePaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddEvidencePaymentDisputeResponseTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\FileEvidenceTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers everything `getPaymentDisputeEvidenceApi()` needs. Self-contained
 * beyond {@see CoreServiceRegistrar}: its request/response transformers and
 * serializers are not shared with {@see PaymentDisputeServiceRegistrar}.
 */
final class PaymentDisputeEvidenceServiceRegistrar implements ServiceRegistrarInterface
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
        $container->register(SellFulfillmentInterface::SERVICE_PAYMENT_DISPUTE_EVIDENCE_API, PaymentDisputeEvidenceApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_API_REQUEST_SENDER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ARRAY_TO_JSON_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_RESPONSE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FILE_EVIDENCE_TRANSFORMER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_UPDATE_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_CREDENTIALS),
                    $this->apiHost,
                ]
            );
    }

    private static function registerSerializers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_FILE_EVIDENCE_SERIALIZER, FileEvidenceSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_FILE_EVIDENCES_SERIALIZER, FileEvidencesSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FILE_EVIDENCE_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEM_SERIALIZER, OrderLineItemSerializer::class);

        $container->register(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEMS_SERIALIZER, OrderLineItemsSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEM_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER, AddEvidencePaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FILE_EVIDENCES_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEMS_SERIALIZER),
                ]
            );

        $container->register(SellFulfillmentInterface::SERVICE_UPDATE_EVIDENCE_PAYMENT_DISPUTE_REQUEST_SERIALIZER, UpdateEvidencePaymentDisputeRequestSerializer::class)
            ->setArguments(
                [
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_FILE_EVIDENCES_SERIALIZER),
                    $container->getDefinition(SellFulfillmentInterface::SERVICE_ORDER_LINE_ITEMS_SERIALIZER),
                ]
            );
    }

    private static function registerTransformers(ContainerBuilder $container): void
    {
        $container->register(SellFulfillmentInterface::SERVICE_ADD_EVIDENCE_PAYMENT_DISPUTE_RESPONSE_TRANSFORMER, AddEvidencePaymentDisputeResponseTransformer::class);

        $container->register(SellFulfillmentInterface::SERVICE_FILE_EVIDENCE_TRANSFORMER, FileEvidenceTransformer::class);
    }
}
