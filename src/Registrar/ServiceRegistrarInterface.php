<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Registrar;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void;
}
