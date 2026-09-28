<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment;

use ChristianBrown\EBay\SellFulfillment\Registrar\ServiceRegistrarInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ContainerFactoryInterface
{
    /**
     * @param array<int, ServiceRegistrarInterface> $registrars
     */
    public function build(array $registrars): ContainerBuilder;
}
