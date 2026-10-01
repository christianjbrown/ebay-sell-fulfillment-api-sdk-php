<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use ChristianBrown\EBay\SellFulfillment\SellFulfillmentInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelRequestTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\CancelStatusTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the order cancel request and cancel status transformers. Must run after {@see CoreServiceRegistrar}.
 */
final class OrderCancelTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
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
    }
}
