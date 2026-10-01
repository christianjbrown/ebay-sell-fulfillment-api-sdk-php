<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\Api\OrderApi;
use ChristianBrown\EBay\SellFulfillment\Http\ApiHostInterface;
use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers `OrderApi` itself, from the transformers and serializer the other
 * order registrars provide. Must run after every Order*TransformerRegistrar
 * and {@see OrderSerializerRegistrar}.
 */
final class OrderApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
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
}
