<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\EBay\SellFulfillment\Registrar\ServiceRegistrarInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function array_map;

final class ContainerFactory implements ContainerFactoryInterface
{
    /**
     * @param array<int, ServiceRegistrarInterface> $registrars
     */
    public function build(array $registrars): ContainerBuilder
    {
        $container = new ContainerBuilder();

        return self::applyRegistrars($registrars, $container);
    }

    /**
     * @param array<int, ServiceRegistrarInterface> $registrars
     */
    private static function applyRegistrars(array $registrars, ContainerBuilder $container): ContainerBuilder
    {
        array_map(
            static function (ServiceRegistrarInterface $registrar) use ($container): void {
                $registrar->register($container);
            },
            $registrars
        );

        return $container;
    }
}
